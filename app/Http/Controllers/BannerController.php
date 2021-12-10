<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBanner($id)
    {
        return Banner::find($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $banner = new Banner;
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->subtitle = $request->subtitle;
        $banner->button_text = $request->button_text;
        $banner->link = $request->link;
        $banner->icon = $request->icon;
        $banner->status = $request->status;

        if ($request->hasfile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('banner', $imageName);

            $banner->image = $imageName;
        }

        if ($request->hasfile('logo')) {
            $logoName = time().'_'.$request->file('logo')->getClientOriginalName();
            $request->file('logo')->storeAs('logo', $logoName);

            $banner->logo = $logoName;
        }

        $banner->save();

        return response()->json([
            'message' => 'Successfully Created',
            'data' => Banner::get()
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return Banner::get();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->subtitle = $request->subtitle;
        $banner->button_text = $request->button_text;
        $banner->link = $request->link;
        $banner->icon = $request->icon;
        $banner->status = $request->status;

        if ($request->hasfile('image')) {
            Storage::disk('public')->delete($request->oldBannerImage);

            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('banner', $imageName);

            $banner->image = $imageName;
        }

        if ($request->hasfile('logo')) {
            Storage::disk('public')->delete($request->oldLogoImage);

            $logoName = time().'_'.$request->file('logo')->getClientOriginalName();
            $request->file('logo')->storeAs('logo', $logoName);

            $banner->logo = $logoName;
        }

        $banner->save();

        return response()->json([
            'message' => `Banner successfully updated.`,
            'data' => Banner::get()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->update(['status' => 2]);
        return Banner::get();
    }
}