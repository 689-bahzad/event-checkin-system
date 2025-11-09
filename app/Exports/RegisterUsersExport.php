<?php
namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegisterUsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Registration::with('sittingTable')->select("id", "id_number", "count", "name", "email", "phone_number", "gender", "department", "lucky_number", "qr_status", "type")->get();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Sr No", "Id Number", "Name", "Email", "Phone Number", "Gender", "Department", "Lucky Number", "Has Checked", "Category", "Table Name"];
    }

    public function map($eventUser): array
    {
        return [
            $eventUser->count,
            $eventUser->id_number ?? '-',
            $eventUser->name,
            $eventUser->email,
            $eventUser->phone_number,
            $eventUser->gender,
            $eventUser->department,
            $eventUser->lucky_number, 
            $eventUser->qr_status ? 'Yes' : 'No',
            $eventUser->type,
            $eventUser->sittingTable->first()->name ?? 'N/A',
        ];
    }
}
