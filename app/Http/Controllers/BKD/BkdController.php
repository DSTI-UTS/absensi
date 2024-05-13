<?php

namespace App\Http\Controllers\BKD;

use App\Http\Controllers\Controller;
use App\Models\Bkd;
use Illuminate\Http\Request;

/**
 * Class BkdController
 * @package App\Http\Controllers
 */
class BkdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bkds = Bkd::paginate(10);

        return view('BKD.index', compact('bkds'))
            ->with('i', (request()->input('page', 1) - 1) * $bkds->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bkd = new Bkd();
        return view('BKD.create', compact('bkd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Bkd::$rules);

        $bkd = Bkd::create($request->all());

        return redirect()->route('bkds.index')
            ->with('success', 'Bkd created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bkd = Bkd::find($id);

        return view('BKD.show', compact('bkd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bkd = Bkd::find($id);

        return view('BKD.edit', compact('bkd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Bkd $bkd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bkd $bkd)
    {
        request()->validate(Bkd::$rules);

        $bkd->update($request->all());

        return redirect()->route('bkds.index')
            ->with('success', 'Bkd updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $bkd = Bkd::find($id)->delete();

        return redirect()->route('bkds.index')
            ->with('success', 'Bkd deleted successfully');
    }
}
