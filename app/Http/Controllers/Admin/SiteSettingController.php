<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $site_settings = SiteSetting::query()->get();
        $site_css = SiteSetting::query()->first();

        return view('backend.site-setting.index',compact('site_settings','site_css'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
         'image' => 'required|image|mimes:jpeg,png,jpg,|max:5048',
        ]);

        // dd($request->file('image'));
        $siteSetting = SiteSetting::findOrFail($id);

        if ($request->has('image')) {
            $siteSetting->clearMediaCollection('images');
            $siteSetting->addMediaFromRequest('image')->toMediaCollection('images');
            return redirect()->back()->with('success', 'Image updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

     /**
     * Update the specified resource in storage.
     */
    public function updateStyle(Request $request)
    {
        $site_setting = SiteSetting::query()->first();

        $site_setting->site_css = $request->site_css;
        $site_setting->save();

        return back()->with('success','CSS updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
