<?php

namespace App\Http\Controllers\BKD;

use App\Http\Controllers\Controller;
use App\Models\HumanResource;
use App\Services\Sister;

class DashboardController extends Controller
{
    public function index()
    {
        Sister::authorize();
        return view("SDM.index", [
            "sdm" => HumanResource::searchSDM()
        ]);
    }

    public function setSession($id_sdm, $nama_sdm)
    {
        Sister::authorize();
        session(['id_sdm' => $id_sdm, 'nama_sdm' => $nama_sdm]);
        return redirect(route('index'));
    }
}
