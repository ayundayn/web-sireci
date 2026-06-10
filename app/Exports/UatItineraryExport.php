<?php

namespace App\Exports;

use App\Models\UatAnswer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UatItineraryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return UatAnswer::with('user')->get()->map(function ($item) {

            return [
                'Nama User' => $item->user->name ?? '-',
                'Email' => $item->user->email ?? '-',

                'Jenis Kelamin' => $item->jenis_kelamin,
                'Usia' => $item->usia,

                'Pekerjaan' => $item->pekerjaan,

                'Pekerjaan Lainnya' => $item->pekerjaan_lainnya,

                'Asal Daerah' => $item->asal_daerah,

                'Frekuensi Digital' => $item->frekuensi_digital,

                'Sumber Informasi SIRECI' => $item->sumber_informasi,

                'Q1' => $item->q9,
                'Q2' => $item->q10,
                'Q3' => $item->q11,
                'Q4' => $item->q12,
                'Q5' => $item->q13,
                'Q6' => $item->q14,
                'Q7' => $item->q15,
                'Q8' => $item->q16,
                'Q9' => $item->q17,
                'Q10' => $item->q18,
                'Q11' => $item->q19,
                'Q12' => $item->q20,
                'Q13' => $item->q21,
                'Q14' => $item->q22,
                'Q15' => $item->q23,

                'Saran_Pengguna' => $item->saran_pengguna,

                'Tanggal' => $item->created_at->format('d-m-Y H:i')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama User',
            'Email',

            'Jenis Kelamin',
            'Usia',

            'Pekerjaan',
            'Pekerjaan Lainnya',

            'Asal Daerah',

            'Frekuensi Digital',

            'Sumber Informasi SIRECI',

            'Q1',
            'Q2',
            'Q3',
            'Q4',
            'Q5',
            'Q6',
            'Q7',
            'Q8',
            'Q9',
            'Q10',
            'Q11',
            'Q12',
            'Q13',
            'Q14',
            'Q15',

            'Saran_Pengguna',

            'Tanggal'
        ];
    }
}
