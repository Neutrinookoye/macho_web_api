<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportLead implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return Lead::select('first_name', 'last_name', 'job_title', 'email', 'organization', 'country', 'brief', 'services')->orderBy('created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return[
            'First Name',
            'Last Name',
            'Job Title',
            'Email',
            'Organization',
            'Country',
            'Brief',
            'Services',
        ];
    }
}
