<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('user_id', auth()->id())->paginate(10);
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required|min:3',
            'email'           => 'required|email|unique:customers,email',
            'no_hp'           => 'required',
            'jenis_makeup'    => 'required|in:Graduation,Wedding,Party,Engagement,Daily',
            'harga'           => 'required|numeric|min:0',
            'tanggal_booking' => 'required|date',
            'foto'            => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $data            = $request->all();
        $data['aktif']   = $request->aktif == '1';
        $data['user_id'] = auth()->id();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        Customer::create($data);

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil ditambahkan!');
    }

    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nama'            => 'required|min:3',
            'email'           => 'required|email|unique:customers,email,'.$customer->id,
            'no_hp'           => 'required',
            'jenis_makeup'    => 'required|in:Graduation,Wedding,Party,Engagement,Daily',
            'harga'           => 'required|numeric|min:0',
            'tanggal_booking' => 'required|date',
            'foto'            => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $data          = $request->except('foto');
        $data['aktif'] = $request->aktif == '1';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $customer->update($data);

        return redirect()->route('customer.index')
            ->with('success', 'Data customer berhasil diupdate!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');
        $customers = Customer::where('user_id', auth()->id())
            ->where(function ($query) use ($q) {
                $query->where('nama', 'like', "%$q%")
                      ->orWhere('email', 'like', "%$q%")
                      ->orWhere('jenis_makeup', 'like', "%$q%");
            })
            ->get();

        return response()->json($customers);
    }
}

