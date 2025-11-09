<?php

namespace App\Imports;

use App\Models\Registration;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Log;

class RegistrationsImport implements ToModel, WithHeadingRow
{
    /**
     * Don’t transform the heading row—use the exact column names.
     */
    public static function headingRowFormatter(): string
    {
        return 'none';
    }

    /**
     * Transform each row into a Registration model.
     *
     * @param array $row
     * @return \App\Models\Registration
     */
    public function model(array $row)
    {

        $admin = \App\Models\User::query()->where('role', 'admin')->first();

        $name        = Arr::get($row, 'name');
        $email       = Arr::get($row, 'email') == '-' ? null : Arr::get($row, 'email') ?? null;
        $phoneNumber = Arr::get($row, 'phone') == '-' ? null : Arr::get($row, 'phone') ?? null;
        $gender        = Arr::get($row, 'gender') == '-' ? null : Arr::get($row, 'gender') ?? null;
        $type        = Arr::get($row, 'type') == '-' ? null : Arr::get($row, 'type') ?? null;
        $department  = Arr::get($row, 'department') == '-' ? null : Arr::get($row, 'department') ?? null;
        $id_number    = Arr::get($row, 'id_number') == '-' ? null : Arr::get($row, 'id_number') ?? null;
        $qrStatus    = isset($row['qr_status'])    ? (int) $row['qr_status']    : 0;
        $isCheckOut  = isset($row['is_check_out']) ? (int) $row['is_check_out'] : 0;
        $status      = isset($row['status'])       ? (int) $row['status']       : 0;

        $currentCount   = Registration::count() + 1;
        $luckyNumber = (string) ($currentCount + 1000);
        Log::info('Current email: ' . $email);
        $qrFileName = 'qrcode_' . Str::uuid() . '.png';
        $qrDirectory = public_path('qrcodes');

        if (! file_exists($qrDirectory)) {
            mkdir($qrDirectory, 0755, true);
        }

        $qrFilePath = $qrDirectory . DIRECTORY_SEPARATOR . $qrFileName;

        QrCode::format('png')
            ->size(300)
            ->generate($id_number === null ? $phoneNumber : $id_number, $qrFilePath);

        $lookup = [];
        if (! empty($id_number)) {
            $lookup['id_number'] = $id_number;
        } elseif (! empty($phoneNumber)) {
            $lookup['phone_number'] = $phoneNumber;
        }

        $attributes = [
            'name'          => $name,
            'email'         => $email,
            'id_number'     => $id_number,
            'department'    => $department,
            'gender'        => $gender,
            'phone_number'  => $phoneNumber,
            'count'         => $currentCount,
            'type'          => $type,
            'lucky_number'  => $luckyNumber,
            'qr_status'     => $qrStatus,
            'is_check_out'  => $isCheckOut,
            'status'        => $status,
            'qr_code_path'  => 'qrcodes/' . $qrFileName,
        ];

        if (count($lookup)) {
            $registration = Registration::updateOrCreate($lookup, $attributes);
        } else {
            $registration = Registration::create($attributes);
        }

        if ($registration->email && $admin->is_send_email_notification && !$registration->is_email_sent) {
            Mail::to($registration->email)->send(new RegistrationConfirmation($registration));
            $registration->is_email_sent = true;
            $registration->save();
            Log::info('Sending email to: ' . $registration->email);
        }
       

        return $registration;
    }
}
