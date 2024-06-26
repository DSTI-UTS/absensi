<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StructuralPosition\StoreStructuralPositionRequest;
use App\Http\Requests\StructuralPosition\UpdateStructuralPositionRequest;
use App\Models\StructuralPosition;
use App\Models\HumanResource;
use App\Models\Structure;
use Illuminate\Http\Request;

class StructuralPositionController extends Controller
{
    public function create()
    {
        return view('admin.structure.assign.create')
            ->with('human_resources', HumanResource::selectAllOption())
            ->with('structurals', Structure::selectOptionStructure());
    }

    public function store(StoreStructuralPositionRequest $request)
    {
        $form = $request->safe()->only(['sdm_id', 'structure_id']);
        StructuralPosition::create($form);
        return redirect()->route('structure.index')->with('message', 'Berhasil assign jabatan struktural');
    }

    public function edit(StructuralPosition $assign)
    {
        return view('admin.structure.assign.edit')
            ->with('assign', $assign)
            ->with('human_resources', HumanResource::selectAllOption())
            ->with('structurals', collect(Structure::selectOptionStructure())->filter(function ($item) use ($assign) {
                return $item['value'] === $assign->structure_id;
            }));
    }

    public function update(UpdateStructuralPositionRequest $request, StructuralPosition $assign)
    {
        $form = $request->safe()->only(['sdm_id', 'structure_id']);
        $assign->update($form);
        return redirect()->route('structure.index')->with('message', 'Berhasil edit assign jabatan struktural');
    }

    public function destroy(StructuralPosition $structuralPosition)
    {
        $structuralPosition->delete();
        return redirect()->route('structure.index')->with('message', 'Berhasil delete assign jabatan struktural');
    }

    public function removeStructuralPosition($sdm_id, $structural_id)
    {
        $structuralPosition = StructuralPosition::where('structure_id', $structural_id)
            ->where('sdm_id', $sdm_id)
            ->first();

        if (!$structuralPosition) return back()->with('error', 'Gagal menghapus jabatan struktural. Data tidak ditemukan.');
        $structuralPosition->delete();
        return back()->with('message', 'Berhasil menghapus jabatan struktural dengan ID ' . $structural_id . ' dan ID SDM ' . $sdm_id . '.');
    }
}
