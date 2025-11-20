<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class DrinkRedemptionController extends Controller
{
    /**
     * Display drink redemption management page
     */
    public function index()
    {
        $registrations = Registration::query()->get();
        return view('backend.drink-redemption.index', compact('registrations'));
    }

    /**
     * Toggle drink redemption permission for a registration
     */
    public function togglePermission(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'can_redeem' => 'required|boolean'
        ]);

        $registration = Registration::findOrFail($request->registration_id);
        $registration->can_redeem_drinks = $request->can_redeem;
        $registration->save();

        return response()->json([
            'success' => true,
            'message' => $request->can_redeem ? 'Drink redemption enabled' : 'Drink redemption disabled'
        ]);
    }
}
