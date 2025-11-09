<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use App\Models\Registration;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedback_page = SiteSetting::query()->where('page_title','feedback')->first();
        return view('frontend.pages.feedback', compact('feedback_page'));
    }


     /**
     * Display a listing of the resource.
     */
    public function allFeedback()
    {
        $all_feedbacks = FeedBack::query()->get();
        return view('backend.feedback.index', compact('all_feedbacks'));
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
        ]);

        $exist = FeedBack::query()->where('name', $request->name)->first();

        $is_registered = Registration::query()->where('name', $request->name)->first();

        // if ($exist) {
        //     return back()->with('error', 'You have already given feedback');
        // } 

        FeedBack::create([
            'name' => $request->name,
            'message' => $request->message,
        ]);
        // if ($is_registered) {
            
        // } else {

        //     return redirect('/')->with('error', 'You are not registered');
        // }

        return redirect('/')->with('success', 'Thank you for your feedback');
    }

    /**
     * Display the specified resource.
     */
    public function show(FeedBack $feedBack)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeedBack $feedBack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeedBack $feedBack)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeedBack $feedBack)
    {
        //
    }
}
