<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
   
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('backend.setting.index');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        if ($request->has('name')) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id . ''],
            ]);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        }
        if($request->has('redeem_code')) {
          $request->validate([
                'redeem_code' => ['required', 'string', 'regex:/^[A-Za-z0-9]{2}$/'],
            ]);
            $user->redeem_code = $request->redeem_code;
            $user->save();
        }
        if ($request->has('is_check_in_check_out')) {
          
           $user->is_check_in_check_out = $request->boolean('is_check_in_check_out');
            $user->save();

        } 
        if ($request->has('is_send_email_notification')) {

            $user->is_send_email_notification = $request->boolean('is_send_email_notification');
            $user->save();

        }
        if ($request->has('new_password')) {
            if (empty($request->old_password) || empty($request->new_password)) {
                return back()->with("error", "Old Password and New Password fields are Required");
            }
            if ($request->new_password != $request->new_password_confirmation) {
                return back()->with("error", "New Password Doesn't match with Confirm Password");
            }
            #Match The Old Password
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return back()->with("error", "Old Password Doesn't match!");
            }

            #Update the new Password
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
        }
        return back()->with('success', 'Porfile updated successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
