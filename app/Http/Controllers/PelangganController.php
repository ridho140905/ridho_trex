<?php
namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Multipleupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        ->withquerystring();

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
        //dd($request->all());
        $data['first_name'] = $request->first_name;
        $data['last_name']  = $request->last_name;
        $data['birthday']   = $request->birthday;
        $data['gender']     = $request->gender;
        $data['email']      = $request->email;
        $data['phone']      = $request->phone;

        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::with('files')->findOrFail($id);
        return view('admin.pelanggan.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelanggan_id = $id;
        $pelanggan    = Pelanggan::findOrFail($pelanggan_id);

        $pelanggan->first_name = $request->first_name;
        $pelanggan->last_name  = $request->last_name;
        $pelanggan->birthday   = $request->birthday;
        $pelanggan->gender     = $request->gender;
        $pelanggan->email      = $request->email;
        $pelanggan->phone      = $request->phone;

        $pelanggan->save();

        return redirect()->route('pelanggan.index')->with('success', 'Perubahan Data Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Hapus semua file terkait pelanggan ini
        foreach ($pelanggan->files as $file) {
            Storage::disk('public')->delete($file->filename);
            $file->delete();
        }

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Upload multiple files untuk pelanggan
     */
    public function uploadFiles(Request $request, string $id)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'mimes:doc,docx,pdf,jpg,jpeg,png,gif,txt|max:2048'
        ]);

        $pelanggan = Pelanggan::findOrFail($id);

        if ($request->hasfile('files')) {
            $uploadedFiles = [];

            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    // Generate unique filename
                    $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $file->getClientOriginalName());

                    // Store file
                    $path = $file->storeAs('pelanggan_files', $filename, 'public');

                    // Simpan ke database
                    $uploadedFiles[] = [
                        'filename' => $path,
                        'ref_table' => 'pelanggan',
                        'ref_id' => $pelanggan->pelanggan_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Insert semua file sekaligus
            Multipleupload::insert($uploadedFiles);

            return redirect()->route('pelanggan.show', $id)->with('success', 'File berhasil diupload!');
        }

        return redirect()->route('pelanggan.show', $id)->with('error', 'Gagal upload file!');
    }

    /**
     * Hapus file pelanggan
     */
    public function deleteFile(string $pelangganId, string $fileId)
    {
        $file = Multipleupload::where('id', $fileId)
                            ->where('ref_table', 'pelanggan')
                            ->where('ref_id', $pelangganId)
                            ->firstOrFail();

        // Hapus file dari storage
        Storage::disk('public')->delete($file->filename);

        // Hapus dari database
        $file->delete();

        return redirect()->route('pelanggan.show', $pelangganId)->with('success', 'File berhasil dihapus!');
    }
}
