<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller {
    public function index() {
        $layanans = Layanan::latest()->paginate(10);
        return view('admin.layanan.index', compact('layanans'));
    }

    public function create() {
        return view('admin.layanan.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama'         => 'required',
            'harga'        => 'required|numeric',
            'harga_hairdo' => 'required|numeric',
            'durasi'       => 'required|integer',
            'foto'         => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $data = $request->all();
        $data['is_active'] = true;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('layanan', 'public');
        }

        Layanan::create($data);
        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Layanan $layanan) {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan) {
        $request->validate([
            'nama'  => 'required',
            'harga' => 'required|numeric',
            'durasi'=> 'required|integer',
            'foto'  => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('layanan', 'public');
        }

        $layanan->update($data);
        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diupdate!');
    }

    public function destroy(Layanan $layanan) {
        $layanan->delete();
        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
