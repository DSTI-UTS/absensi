<?php

namespace App\Http\Controllers\Presence;

use App\Http\Controllers\Controller;
use App\Http\Requests\Presence\StorePresenceRequest;
use App\Http\Requests\Presence\UpdatePresenceRequest;
use App\Models\Presence;
use App\Models\HumanResource;
use App\Models\Structure;
use App\Models\Subject;
use App\Traits\Utils\CustomPaginate;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    use CustomPaginate;

    public function index()
    {
        return view('home');
    }

    public function myPresence()
    {
        return view('presence.civitas.index')
            ->with('withDate', true)
            ->with('exportUrl', request()->getQueryString())
            ->with('presences', Presence::getAllPresences([Auth::id()]))
            ->with('hours', Presence::getPresenceHoursUser(Auth::id()));
    }

    public function subPresence()
    {
        return view('presence.civitas.unit.detail')
            ->with('withDate', true)
            ->with('exportUrl', request()->getQueryString())
            ->with('presences', Presence::subPresence())
            ->with('hours', Presence::subPresenceHour());
    }

    public function create()
    {
        return view('presence.dashboard.create')
            ->with('human_resources', HumanResource::selectAllOption());
    }

    public function store(StorePresenceRequest $request)
    {
        $form = $request->safe()->only(['sdm_id', 'check_in_time', 'latitude_in', 'longitude_in']);
        Presence::create($form);
        return redirect()->route('presence.index')->with('message', "Berhasil menambah presensi kehadiran");
    }

    public function detail($sdm_id)
    {
        return view('presence.dashboard.index')
            ->with('withDate', true)
            ->with('sdm', HumanResource::where('id', $sdm_id)->first())
            ->with('exportUrl', '')
            ->with('presences', Presence::getAllPresences([$sdm_id]));
    }

    public function edit(Presence $presence)
    {
        return view('presence.dashboard.edit')
            ->with('presence', $presence)
            ->with('human_resources', HumanResource::selectAllOption());
    }

    public function update(UpdatePresenceRequest $request, Presence $presence)
    {
        $form = $request->safe()->only(['check_out_time', 'latitude_out', 'longitude_out']);
        $presence->update($form);
        return redirect()->route('presence.index')->with('message', "Berhasil edit presensi kehadiran");
    }

    public function destroy(Presence $presence)
    {
        $presence->delete();
        return redirect()->route('presence.index')->with('message', "Berhasil hapus presensi kehadiran");
    }
}
