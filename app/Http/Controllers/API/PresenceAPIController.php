<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Presence\StorePresenceRequestAPI;
use App\Http\Requests\Presence\UpdatePresenceRequestAPI;
use App\Models\Presence;
use Carbon\Carbon;

class PresenceAPIController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Presence::myPresenceAPI(request()->user()->id)
        ]);
    }

    public function store(StorePresenceRequestAPI $request)
    {
        // $presence = Presence::where('sdm_id', $request->user()->id)
        //     ->whereDate('check_in_time', Carbon::today())
        //     ->first();
        // if ($presence) {
        //     return response()->json([
        //         'message' => 'Hari ini sudah mengisi presensi'
        //     ], 422);
        // }
        $form = [
            'sdm_id' => $request->user()->id,
            'check_in_time' => date('Y-m-d H:i:s'),
            'latitude_in' => $request->input('latitude'),
            'longitude_in' => $request->input('longitude')
        ];
        if (!$form['sdm_id']) {
            return response()->json([
                'message' => 'Pastikan token benar'
            ], 422);
        }
        if (!$form['check_in_time']) {
            return response()->json([
                'message' => 'Pastikan datetime server benar'
            ], 422);
        }
        $presence = Presence::create($form);
        return response()->json([
            'data' => $presence
        ]);
    }

    public function show(Presence $presence)
    {
        return response()->json([
            'data' => $presence
        ]);
    }

    public function update(UpdatePresenceRequestAPI $request)
    {
        $presence = Presence::where('sdm_id', request()->user()->id)
            ->whereDate('check_in_time', Carbon::today())
            ->latest()
            ->first();
        if (empty($presence)) {
            return response()->json([
                'message' => 'Anda belum absen masuk'
            ], 422);
        }
        // if ($presence->check_out_time) {
        //     return response()->json([
        //         'message' => 'Sudah ter-absensi pulang'
        //     ], 422);
        // }
        $presence->check_out_time = date('Y-m-d H:i:s');
        $presence->latitude_out = $request->input('latitude');
        $presence->longitude_out = $request->input('longitude');
        if (!$presence->check_out_time) {
            return response()->json([
                'message' => 'Pastikan datetime server benar'
            ], 422);
        }
        $presence->save();
        return response()->json([
            'data' => $presence
        ]);
    }
}