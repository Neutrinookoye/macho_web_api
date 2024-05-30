<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewsLetterExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $newsletters;

    public function __construct(Collection $newsletters)
    {
        $this->newsletters = $newsletters;
    }

    public function collection()
    {
        //
        // return $this->newsletters;
        $filtered = $this->newsletters->map(function ($newsletter, $index) {
            return [
                'S/N' => $index + 1,
                'Email' => $newsletter->email,
            ];
        });

        return $filtered;
    }

    public function headings(): array
    {
        return[
            'S/N',
            'Email',
        ];
    }
}
