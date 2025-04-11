<?php

namespace App\Http\Controllers;

use App\Models\PenilaianModel;
use App\Models\AlternatifModel;
use App\Models\KriteriaModel;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        return view('penilaian.index', [
            'penilaian' => PenilaianModel::with(['alternatif', 'kriteria', 'user'])
                            ->filter(request(['search']))
                            ->paginate(10)
        ]);
    }

    public function create()
    {
        return view('penilaian.create', [
            'alternatifs' => AlternatifModel::all(),
            'kriterias' => KriteriaModel::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idalternatif' => 'required|exists:spkmaut_alternatif,idalternatif',
            'idkriteria' => 'required|exists:spkmaut_kriteria,idkriteria',
            'minmax' => 'required|in:min,max',
            'matrixnormalisasi' => 'required|numeric',
            'hasil' => 'required|numeric'
        ]);

        // Tambahkan id user yang login
        $validated['iduser'] = auth()->user()->iduser;

        PenilaianModel::create($validated);

        return redirect('/penilaian')->with('success', 'Data penilaian berhasil ditambahkan!');
    }

    public function edit(PenilaianModel $penilaian)
    {
        return view('penilaian.edit', [
            'penilaian' => $penilaian,
            'alternatifs' => AlternatifModel::all(),
            'kriterias' => KriteriaModel::all()
        ]);
    }

    public function update(Request $request, PenilaianModel $penilaian)
    {
        $validated = $request->validate([
            'idalternatif' => 'required|exists:spkmaut_alternatif,idalternatif',
            'idkriteria' => 'required|exists:spkmaut_kriteria,idkriteria',
            'minmax' => 'required|in:min,max',
            'matrixnormalisasi' => 'required|numeric',
            'hasil' => 'required|numeric'
        ]);

        $penilaian->update($validated);

        return redirect('/penilaian')->with('success', 'Data penilaian berhasil diperbarui!');
    }

    public function destroy(PenilaianModel $penilaian)
    {
        $penilaian->delete();
        return redirect('/penilaian')->with('success', 'Data penilaian berhasil dihapus!');
    }
}