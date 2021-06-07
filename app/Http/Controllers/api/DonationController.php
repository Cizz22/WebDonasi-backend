<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Illuminate\Support\Str;

class DonationController extends Controller
{

        /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        // Set midtrans configuration
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donations = Donation::with('campaigns')->where('donatur_id', auth()->guard('api')->user()->id)->latest()->paginate(5);
        $response = [
            'success' => true,
            'message' => 'Data Donasi',
            'data' => $donations
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $length = 10;
            $random='';
            for ($i = 0; $i<$length;$i++){
                $random .= rand(0,1) ? rand(0,9) : chr(rand(ord('a'), ord('z')));
            }

            $invoice = 'TRX-'.Str::upper($random);

            $campaign = Campaign::where('slug', $request->campaignSlug)->first();

            $donation = Donation::create([
                'invoice' => $invoice,
                'amount' => $request->amount,
                'pray' => $request->pray,
                'campaign_id' => $campaign->id,
                'user_id' => auth()->guard('api')->user()->id,
                'status'        => 'pending',
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id' => $donation->invoice,
                    'gross_amount' => $donation->amount
                ],
                'customer_details' => [
                    'first_name' => auth()->guard('api')->user()->name,
                    'email' => auth()->guard('api')->user()->email,
                ]
            ];

            $snaptoken = Snap::getSnapToken($payload);
            $donation->snap_token = $snaptoken;
            $donation->save();

            $this->response['snap_token'] = $snaptoken;
        });

        return response()->json([
            'success' => true,
            'message' => 'Donasi Berhasil Dibuat!',
            $this->response
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function notificationHandler(Request $request)
    {
        $payload      = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $transaction  = $notification->transaction_status;
        $type         = $notification->payment_type;
        $orderId      = $notification->order_id;
        $fraud        = $notification->fraud_status;

        //data donation
        $data_donation = Donation::where('invoice', $orderId)->first();

        if ($transaction == 'capture') {

            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {

              if($fraud == 'challenge') {

                /**
                *   update invoice to pending
                */
                $data_donation->update([
                    'status' => 'pending'
                ]);

              } else {

                /**
                *   update invoice to success
                */
                $data_donation->update([
                    'status' => 'success'
                ]);

              }

            }

        } elseif ($transaction == 'settlement') {

            /**
            *   update invoice to success
            */
            $data_donation->update([
                'status' => 'success'
            ]);


        } elseif($transaction == 'pending'){


            /**
            *   update invoice to pending
            */
            $data_donation->update([
                'status' => 'pending'
            ]);


        } elseif ($transaction == 'deny') {


            /**
            *   update invoice to failed
            */
            $data_donation->update([
                'status' => 'failed'
            ]);


        } elseif ($transaction == 'expire') {


            /**
            *   update invoice to expired
            */
            $data_donation->update([
                'status' => 'expired'
            ]);


        } elseif ($transaction == 'cancel') {

            /**
            *   update invoice to failed
            */
            $data_donation->update([
                'status' => 'failed'
            ]);

        }

    }
}
