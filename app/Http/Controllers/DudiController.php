<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dudi;
use App\Imports\DudiImport;
use Illuminate\Support\Facades\Auth;
use App\Models\Kaprodi;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;
use App\Models\Kompetensi_keahlian;
use App\Models\Guru_pembimbing;

class DudiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if (Gate::allows('admin')) {
            $dudi = Dudi::all();
            $kompetensi_keahlian = Kompetensi_keahlian::all();
            return view('home.dudi.index', compact('dudi', 'kompetensi_keahlian'));
        }else {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dudi' => 'required|string|max:255',
            'alamat_dudi' => 'nullable|string|max:255',
            'no_telp_dudi' => 'nullable|string|max:20',
            'jabatan_pimpinan' => 'nullable|string|max:50',
            'nomor_kepegawaian' => 'nullable|string|max:50',
            'nama_pimpinan_dudi' => 'nullable|string|max:255',
            'kuota' => 'required|string|max:255',
            'kompetensi_keahlian_id' => 'required|exists:kompetensi_keahlian,id',
        ]);
        Dudi::create(
            $request->all()
        );
        return redirect()->route('dudi.index')->with('success', 'DUDI berhasil ditambahkan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new DudiImport, $request->file('file'));

        return redirect()->back()->with('success', 'Import berhasil!');
    }

    public function edit($id)
    {
        $data = Dudi::findOrFail($id);

        if (Gate::allows('admin')) {
            $kompetensi_keahlian = Kompetensi_keahlian::all();
        }else {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('home.dudi.edit', compact('data', 'kompetensi_keahlian'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_dudi' => 'required|string|max:255',
            'alamat_dudi' => 'nullable|string|max:255',
            'no_telp_dudi' => 'nullable|string|max:20',
            'jabatan_pimpinan' => 'nullable|string|max:50',
            'nomor_kepegawaian' => 'nullable|string|max:50',
            'nama_pimpinan_dudi' => 'nullable|string|max:255',
            'kuota' => 'nullable|string|max:255',
            'kompetensi_keahlian_id' => 'required|exists:kompetensi_keahlian,id',
        ]);
        Dudi::where('id', $id)->update($validated);
        return redirect()->route('dudi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Dudi::destroy($id);
        return redirect()->route('dudi.index')->with('success', 'Data berhasil dihapus');
    }
}
