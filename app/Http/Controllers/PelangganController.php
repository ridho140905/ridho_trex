<?php
namespace App\Http\Controllers;

use App\Models\MultipleUploads;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterableColumns = ['gender'];
        $searchableColumns = ['first_name', 'last_name', 'email'];

        $data['dataPelanggan'] = Pelanggan::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->withQueryString();
        return view('admin.pelanggan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all())

        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['birthday'] = $request->birthday;
        $data['gender'] = $request->gender;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;

        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data pelanggan
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);

        // Ambil semua file milik pelanggan ini
        $data['pelangganFiles'] = MultipleUploads::where('ref_table', 'pelanggan')
            ->where('ref_id', $data['dataPelanggan']->pelanggan_id) // pastikan ini sesuai kolom ID di DB
            ->get();

        // Kirim ke view
        return view('admin.pelanggan.edit', $data);
    }


    public function detail($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Ambil semua file milik pelanggan ini
        $pelangganFiles = MultipleUploads::where('ref_table', 'pelanggan')
            ->where('ref_id', $pelanggan->pelanggan_id)
            ->get();

        return view('admin.pelanggan.detail', compact('pelanggan', 'pelangganFiles'));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelanggan_id = $id;
        $pelanggan = Pelanggan::findOrFail($pelanggan_id);

        $pelanggan->first_name = $request->first_name;
        $pelanggan->first_name = $request->first_name;
        $pelanggan->first_name = $request->first_name;

        $pelanggan->save();
        return redirect()->route('pelanggan.index')->with('success', 'Perubahan Data Berhasil');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Data berhasil dihapus');
    }
}
