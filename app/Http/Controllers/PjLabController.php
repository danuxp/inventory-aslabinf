<?php

namespace App\Http\Controllers;

use App\Models\NamaLab;
use App\Models\PjLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PjLabController extends Controller
{
    public function index(PjLab $pjLab)
    {
        $mhs = [
            [
                'nim' => '181080200196',
                'nama' => 'Danu'
            ],
            [
                'nim' => '181080200194',
                'nama' => 'Dany'
            ],
            [
                'nim' => '181080200193',
                'nama' => 'Danis'
            ],
        ];
        
        $nama_lab = new NamaLab();

        // var_dump($pjLab->joinData());
        
        $data = [
            'title' => 'Pj Laboratorium',
            'data' => json_encode($mhs, true),
            'nama_lab' => $nama_lab->all()

        ];
        return view('pj_lab.index', $data);
    }

    public function store(Request $request, PjLab $pjLab)
    {
        $rules = [
            'nim' => 'required',
            'lab' => 'required'
        ];

        $message = [
            'nim.required' => 'Kolom nim harus diisi',
            'lab.required' => 'Kolom lab harus diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $nim = $request->nim;
        $lab = $request->lab;
        $nim_data = [];
        // array_push($nim_data, [
        //     'nim' => $nim
        // ]);

        // foreach($nim as $row) {
        //     array_push($nim_data, 
        //         'nim' => $row
        //     );
        // }
        // dd($nim_data);

        $data = [
            'nim' => json_encode(['nim' => $nim]),
            'lab_id' => $lab,
            'status' => 1
        ];

        // $pjLab->create($data);
        // return redirect()->back();
        
    }

    public function update(Request $request) 
    {

    }
}