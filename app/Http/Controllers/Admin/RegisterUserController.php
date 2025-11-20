<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Exports\RegisterUsersExport;
use Illuminate\Http\Request;
use App\Imports\RegistrationsImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\File;

class RegisterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registerUsers = Registration::query()->get();
        return view('backend.event.index',compact('registerUsers'));
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new RegisterUsersExport, 'register-users.csv');
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
    public function updateQrCode(Request $request)
    {
        $registration = Registration::findOrFail($request->content);
        $registration->qr_status = true;
        $registration->save();
        return response()->json(['message' => 'Qr status update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Registration::query()->delete();
        $qrDirectory = public_path('qrcodes');

        if (File::exists($qrDirectory)) {
            File::cleanDirectory($qrDirectory);
        }
        return back()->with('success','Event Clear successfully');
    }
    public function scanQrCodePage()
    {
        // return view('backend.scan-qr-page.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function previewPage()
    {
        $registerUsers = Registration::query()->get();
        return view('backend.preview-page.index', compact('registerUsers'));
    }

   public function import(Request $request)
    {

        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '1024M');
        set_time_limit(900);

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()->all(),
            ], 422);
        }

        $file = $request->file('file');

        $headings   = (new HeadingRowImport)->toArray($file);
        $headerRow  = $headings[0][0] ?? [];

        $requiredColumns   = ['name','id_number','email','phone','gender','department','type'];
        $optionalColumns   = ['qr_status','is_check_out','status'];
        $allAllowed        = array_merge($requiredColumns, $optionalColumns);

        $missing   = array_diff($requiredColumns, $headerRow);
        $unexpected= array_diff($headerRow, $allAllowed);

        if ($missing) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required columns',
                'errors'  => [
                    'Missing: ' . implode(', ', $missing)
                    . '. Required: ' . implode(', ', $requiredColumns)
                    . '. Optional: ' . implode(', ', $optionalColumns)
                ],
            ], 422);
        }

        if ($unexpected) {
            return response()->json([
                'success' => false,
                'message' => 'Unexpected columns',
                'errors'  => [
                    'Unexpected: ' . implode(', ', $unexpected)
                    . '. Only these allowed: ' . implode(', ', $allAllowed)
                ],
            ], 422);
        }

        try {
            DB::transaction(function() use ($file) {
                Excel::import(new RegistrationsImport, $file);
            });

            return response()->json([
                'success'  => true,
                'message'  => 'Registrations imported successfully.',
                'redirect' => route('admin.register.users'),
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle drink redemption permission for a registration
     */
    public function toggleDrinkPermission(Request $request)
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
