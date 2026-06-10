<?php

namespace App\Exports;

use App\Models\UatAnswer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UatRekomendasiExport implements FromCollection, WithHeadings
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

                'Q1' => $item->q1,
                'Q2' => $item->q2,
                'Q3' => $item->q3,
                'Q4' => $item->q4,
                'Q5' => $item->q5,
                'Q6' => $item->q6,
                'Q7' => $item->q7,
                'Q8' => $item->q8,

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

            'Saran_Pengguna',

            'Tanggal'
        ];
    }
}
