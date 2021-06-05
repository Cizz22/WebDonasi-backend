<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.donation.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $this->validate($request, [
            'date_from' => 'required',
            'date_to' => 'required'
        ]);

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $donation = Donation::where('status', 'success')->whereDate('created_at', '<=', $date_to)->whereDate('created_at', '>=', $date_from)->get();
        $total = Donation::where('status', 'success')->whereDate('created_at', '<=', $date_to)->whereDate('created_at', '>=', $date_from)->sum('amount');

        return view('admin.donation.index')->with([
            'donations' => $donation,
            'total' => $total
        ]);
    }

}
