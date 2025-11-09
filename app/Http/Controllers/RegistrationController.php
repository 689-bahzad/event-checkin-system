<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;
use Barryvdh\Snappy\Facades\SnappyImage;
use Illuminate\Support\Str;
class RegistrationController extends Controller
{
    /**
     * Display a view of the resource.
     */
    public function index()
    {
        $home_page = SiteSetting::where('page_title','home')->first();
        $site_css = SiteSetting::query()->first();

        return view('frontend.pages.register',compact('home_page','site_css'));
    }

    public function checkIn()
    {
        $site_css = SiteSetting::query()->first();
        $checkIn_page = SiteSetting::where('page_title','checkIn')->first();
        return view('frontend.pages.check-in',compact('checkIn_page','site_css'));
    }

    public function directCheckIn()
    {
        $site_css = SiteSetting::query()->first();
        $checkIn_page = SiteSetting::where('page_title','directCheckIn')->first();
        return view('frontend.pages.direct-check-in',compact('checkIn_page','site_css'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function verifyUser(Request $request)
    {
        $luckyNumber_page = SiteSetting::query()->where('page_title','luckyNumber')->first();

        $registration = Registration::query()->where('phone_number', $request->phone_number)->orWhere('id_number', $request->phone_number)->first();

        $luckyDraw_page = SiteSetting::query()->where('page_title','luckyDraw')->first();

        $site_css = SiteSetting::query()->first();

        $user = User::query()->where('role', 'admin')->first();

        if ($registration && !$registration->qr_status) {

            $registration->qr_status = true;
            $registration->save();

            if (is_null($user->redeem_code)) {
                return view('frontend.pages.lucky-draw', compact('registration','luckyNumber_page','site_css'));
            } else {
                return view('frontend.pages.redeem-gift', compact('registration','luckyDraw_page','site_css'));
            }
       
        } else if ($registration && $registration->qr_status  && $user->is_check_in_check_out && !$registration->is_check_out) {

            if (is_null($user->redeem_code)) {
                return view('frontend.pages.lucky-draw', compact('registration','luckyNumber_page','site_css'));
            } else {
                return view('frontend.pages.redeem-gift', compact('registration','luckyDraw_page','site_css'));
            }

        
        }  else if ($registration && $registration->qr_status  && $user->is_check_in_check_out && $registration->is_check_out) {

            return view('frontend.pages.lucky-draw', compact('registration','luckyNumber_page','site_css'));

        
        } else if ($registration && $registration->qr_status  && !$user->is_check_in_check_out) {

            if (is_null($user->redeem_code)) {
                return view('frontend.pages.lucky-draw', compact('registration','luckyNumber_page','site_css'));
            } else {
                return view('frontend.pages.redeem-gift', compact('registration','luckyDraw_page','site_css'));
            }
        
        } else {
            return back()->with('error', 'User not found');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $registration = Registration::query()->where('phone_number', $request->phone_number)->orWhere('id_number', $request->id_number)->first();
         
        if(!$registration){
          $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string'],
            'type' => ['required', 'string'],
           'phone_number' => ['required', 'numeric', 'digits_between:9,12'],
          ]);   
        }
       

        $site_css = SiteSetting::query()->first();

        $luckyDraw_page = SiteSetting::query()->where('page_title','luckyDraw')->first();
        
        $qrCode_page = SiteSetting::query()->where('page_title','qrCode')->first();
        
        $luckyNumber_page = SiteSetting::query()->where('page_title','luckyNumber')->first();

        $qrCode = QrCode::size(300)->generate($request->phone_number);


        $user = User::query()->where('role', 'admin')->first();

        if ($registration && $registration->qr_status) {

            if (is_null($user->redeem_code)) {
                return view('frontend.pages.lucky-draw', compact('registration','luckyNumber_page','site_css'));
            } else {
                return view('frontend.pages.redeem-gift', compact('registration','luckyDraw_page','site_css'));
            }
        } else if ($registration && !$registration->qr_status) {

            return view('frontend.pages.qr-code', compact('registration','qrCode','qrCode_page','site_css'));

        } else if ($registration && $registration->qr_status) {

            if (is_null($user->redeem_code)) {
                return view('frontend.pages.lucky-draw', compact('registration','luckyNumber_page','site_css'));
            } else {
                return view('frontend.pages.redeem-gift', compact('registration','luckyDraw_page','site_css'));
            }

        }  else {

            $qrFileName = 'qrcode_' . Str::uuid() . '.png';
            $qrFilePath = public_path('qrcodes/' . $qrFileName);

            if (!file_exists(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0755, true);
            }

            QrCode::format('png')
            ->size(300)
            ->generate($request->phone_number, $qrFilePath);
         
            $count   = Registration::count() + 1;
            $luckyNumber = (string) ($count + 1000);

            $registration = Registration::query()->create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'id_number' => $request->phone_number,
                'count' => $count,
                'type' => $request->type,
                'lucky_number' => $luckyNumber,
                'qr_code_path' => 'qrcodes/' . $qrFileName,
            ]);

            Mail::to($registration->email)->send(new RegistrationConfirmation($registration));

            return view('frontend.pages.qr-code', compact('registration','qrCode','qrCode_page','site_css'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function luckyNumber(Request $request, Registration $registration)
    {

        $registration->status = true;
        $registration->is_check_out = true;
        $site_css = SiteSetting::query()->first();
        $registration->save();

        $luckyNumber_page = SiteSetting::where('page_title','luckyNumber')->first();
       
        return view('frontend.pages.lucky-draw',compact('registration','luckyNumber_page','site_css'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registration $registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registration $registration)
    {
        $registration->status = true;
        $registration->is_check_out = true;
        $registration->save();
        return response()->json(['message' => 'Gift has been redeemed']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration)
    {
        //
    }

    public function validateCode(Request $request)
    {
        $code = $request->input('code');

        $user = User::query()->where('role', 'admin')->first();
        $isValid = $user->redeem_code == $code;
        return response()->json(['valid' => $isValid]);
    }


    public function showLuckyDraw()
    {
        
        $registration = Registration::latest()->first();
        $site_css = SiteSetting::first();
        $luckyNumber_page = SiteSetting::where('page_title', 'luckyNumber')->first();

        return view('frontend.pages.lucky-draw', compact('registration', 'luckyNumber_page', 'site_css'));
    }

}
