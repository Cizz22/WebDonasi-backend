<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [
            'success' => true,
            'message' => 'Data Profile',
            'data' => auth()->guard('api')->user()
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
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $donatur = Donatur::find(auth()->guard('api')->user()->id);

        if($request->file('avatar')){
            //hapus image lama
            Storage::disk('local')->delete('public/donaturs/'.basename($donatur->avatar));

            //upload image baru
            $image = $request->file('avatar');
            $image->storeAs('public/donaturs', $image->hashName());

            $donatur->update([
                'name'      => $request->name,
                'avatar'    => $image->hashName()
            ]);
        }else{
            $donatur->update([
                'name'      => $request->name,
            ]);
        }

        $response=[
            'success' => true,
            'message' => 'Profile Updated',
            'data' => $donatur
        ];

        return response()->json($response, 200);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'password' => 'required|confirmed'
        ]);

        if($validator->fails()) return response()->json($validator->errors(), 400);

        $donatur = Donatur::find(auth()->guard('api')->user()->id);

        $donatur->update([
            'password' => Hash::make($request->password)
        ]);

        $response=[
            'success' => true,
            'message' => 'Profile Updated',
            'data' => $donatur
        ];

        return response()->json($response, 200);
    }
}
