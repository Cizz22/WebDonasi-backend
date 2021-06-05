<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaign = Campaign::latest()->when(request()->q, function($campaign) {
            $campaign = $campaign->where('title', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.campaign.index')->with('campaigns', $campaign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();

        return view('admin.campaign.create')->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:campaigns',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'target_donation' => 'required',
            'max_date' => 'required',
            'category_id' =>'required'
        ]);

         //upload image
        $image = $request->file('image');
        $image->storeAs('public/campaigns', $image->hashName());

       try {
        Campaign::create([
            'image'  => $image->hashName(),
            'title'   => $request->title,
            'description' => $request->description,
            'target_donation' =>$request->target_donation,
            'max_date' =>$request->max_date,
            'category_id' => $request->category_id,
            'user_id' => Auth()->id(),
            'slug'   => Str::slug($request->title, '-')
            ]);
        return redirect()->route('admin.campaign.index')->with(['success' => 'Data Berhasil Disimpan!']);
       }catch (QueryException $e) {
           dd($e);
        return redirect()->route('admin.campaign.index')->with(['error' => 'Data Gagal Disimpan!']);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::latest()->get();
        $campaign = Campaign::findOrFail($id);
        return view('admin.campaign.edit')->with([
            'categories' => $categories,
            'campaign' => $campaign
        ]);
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'target_donation' => 'required',
            'max_date' => 'required',
            'category_id' =>'required'
        ]);
        $campaign = Campaign::findOrFail($id);

        if(!$request->file('image')){
            try {
                $campaign->update([
                    'title'   => $request->title,
                    'description' => $request->description,
                    'target_donation' =>$request->target_donation,
                    'max_date' =>$request->max_date,
                    'category_id' => $request->category_id,
                    'user_id' => Auth()->id(),
                    'slug'   => Str::slug($request->title, '-')
                    ]);
            return redirect()->route('admin.campaign.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } catch (QueryException $e) {
            return redirect()->route('admin.campaign.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    } else{
         //hapus image lama
        Storage::disk('local')->delete('public/campaigns/'.basename($campaign->image));

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/campaigns', $image->hashName());

        try {
            $campaign->update([
                'image'  => $image->hashName(),
                'title'   => $request->name,
                'description' => $request->description,
                'target_donation' =>$request->target_donation,
                'max_date' =>$request->max_date,
                'category_id' => $request->category_id,
                'user_id' => Auth()->id(),
                'slug'   => Str::slug($request->name, '-')
                ]);
            return redirect()->route('admin.campaign.index')->with(['success' => 'Data Berhasil Disimpan!']);
           }catch (QueryException $e) {
            return redirect()->route('admin.campaign.index')->with(['error' => 'Data Gagal Disimpan!']);
           }
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        Storage::disk('local')->delete('public/categories/'.basename($campaign->image));


        try {
            $campaign->delete();

            return response()->json([
                'status' => 'success'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e
            ]);
        }
    }
}
