<?php

namespace App\Exports;

use App\Models\Lead;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportLead implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $leads;
    
    public function __construct(Collection $leads)
    {
        $this->leads = $leads;
    }

    public function collection()
    {
        //
        return $this->leads;
        // return Lead::select('first_name', 'last_name', 'job_title', 'email', 'organization', 'country', 'brief', 'services')->orderBy('created_at', 'DESC')->get();
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
