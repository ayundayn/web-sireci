<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BpwController extends Controller
{
    /**
     * Data Mitra BPW SIRECI
     */
    private array $bpw = [

        [
            'nama' => 'Taman Surga',
            'logo' => 'taman surga.jpg',
            'kontak' => [
                [
                    'nama' => 'Hakam',
                    'wa' => '6282245869569'
                ],
                [
                    'nama' => 'Firriyal',
                    'wa' => '628133086457'
                ]
            ]
        ],

        [
            'nama' => 'Truly Banyuwangi',
            'logo' => 'truly.jpg',
            'kontak' => [
                [
                    'nama' => 'Aditya',
                    'wa' => '6282240754760'
                ],
                [
                    'nama' => 'Erzha',
                    'wa' => '6285889317003'
                ]
            ]
        ],

        [
            'nama' => 'Yuk Banyuwangi',
            'logo' => 'yuk banyuwangi.jpg',
            'kontak' => [
                [
                    'nama' => 'Panji',
                    'wa' => '6285234446334'
                ]
            ]
        ],

        [
            'nama' => 'Onus Travel',
            'logo' => 'onus.jpg',
            'kontak' => [
                [
                    'nama' => 'Dimas',
                    'wa' => '6285236437400'
                ]
            ]
        ],

        [
            'nama' => 'Surya Negara',
            'logo' => 'surya negara.jpg',
            'kontak' => [
                [
                    'nama' => 'Septian',
                    'wa' => '6281515131892'
                ]
            ]
        ],

        [
            'nama' => 'Yuk Experience',
            'logo' => 'yuk experience.jpg',
            'kontak' => [
                [
                    'nama' => 'Bahrul Fahmi',
                    'wa' => '6285806056647'
                ]
            ]
        ],

        [
            'nama' => 'Banyuwangi Ijen Tour',
            'logo' => 'banyuwangi ijen tour.jpg',
            'kontak' => [
                [
                    'nama' => 'Anwar',
                    'wa' => '6283846377895'
                ]
            ]
        ],

        [
            'nama' => 'Gandrung Dewata',
            'logo' => 'gandrung dewata.jpg',
            'kontak' => [
                [
                    'nama' => 'Rudi',
                    'wa' => '6281252400716'
                ],
                [
                    'nama' => 'Ichi',
                    'wa' => '62895413537194'
                ]
            ]
        ],

        [
            'nama' => 'Anugrah Alam Tour and Travel',
            'logo' => 'anugrah alam.jpg',
            'kontak' => [
                [
                    'nama' => 'Febiola',
                    'wa' => '6281235562806'
                ]
            ]
        ],

        [
            'nama' => 'Tour Banyuwangi',
            'logo' => 'tour banyuwangi.png',
            'kontak' => [
                [
                    'nama' => 'Ebbi',
                    'wa' => '628113411712'
                ]
            ]
        ],

        [
            'nama' => 'Miracle Banyuwangi',
            'logo' => 'miracle bwi.jpg',
            'kontak' => [
                [
                    'nama' => 'Siskha',
                    'wa' => '6282146454545'
                ]
            ]
        ],

        [
            'nama' => 'Indah Nusantara',
            'logo' => 'indah nusantara.png',
            'kontak' => [
                [
                    'nama' => 'Jefry',
                    'wa' => '6281336366420'
                ]
            ]
        ],

        [
            'nama' => 'Pesona Ijen',
            'logo' => 'pesona ijen.jpg',
            'kontak' => [
                [
                    'nama' => 'Dhama',
                    'wa' => '6281252693478'
                ]
            ]
        ],

        [
            'nama' => 'Ijen Lava',
            'logo' => 'ijen lava.jpg',
            'kontak' => [
                [
                    'nama' => 'Rini',
                    'wa' => '6281231276259'
                ]
            ]
        ],

    ];

    /**
     * Halaman daftar mitra BPW
     */
    public function index()
    {
        $bpw = collect($this->bpw)
            ->sortBy('nama')
            ->values();

        return view('user.bpw', compact('bpw'));
    }
}
