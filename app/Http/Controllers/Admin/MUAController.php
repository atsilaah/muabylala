<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mua;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MuaController extends Controller {
    public function index() {
        $muas = Mua::with('user')->latest()->paginate(10);
        return view('admin.mua.index', compact('muas'));
    }

    public function create() {
        return view('admin.mua.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'spesialisasi'  => 'nullable',
            'bio'           => 'nullable',
            'foto'          => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => 'mua',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('mua', 'public');
        }

        Mua::create([
            'user_id'      => $user->id,
            'spesialisasi' => $request->spesialisasi,
            'bio'          => $request->bio,
            'foto'         => $foto,
        ]);

        return redirect()->route('admin.mua.index')
            ->with('success', 'MUA berhasil ditambahkan!');
    }

    public function edit(Mua $mua) {
        return view('admin.mua.edit', compact('mua'));
    }

    public function update(Request $request, Mua $mua) {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,'.$mua->user_id,
        ]);

        $mua->user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->hasFile('foto')) {
            $mua->foto = $request->file('foto')->store('mua', 'public');
        }

        $mua->update([
            'spesialisasi' => $request->spesialisasi,
            'bio'          => $request->bio,
            'foto'         => $mua->foto,
        ]);

        return redirect()->route('admin.mua.index')
            ->with('success', 'Data MUA berhasil diupdate!');
    }

    public function destroy(Mua $mua) {
        $mua->user->delete();
        return redirect()->route('admin.mua.index')
            ->with('success', 'MUA berhasil dihapus!');
    }

    public function toggle(Mua $mua) {
        $mua->update(['is_active' => !$mua->is_active]);
        $status = $mua->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "MUA berhasil $status!");
    }
}
