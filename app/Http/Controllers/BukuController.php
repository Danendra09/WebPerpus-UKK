<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Buku;


class BukuController extends Controller
{  
    public function indexPublic(Request $request)
    {
        //Menampilkan Semua Data Di user
        $buku = Buku::all();

        //Mencari Data Di user
        if ($request->has('search')) {
            $search = $request->search;
            $buku = Buku::where('judul', 'LIKE', '%' . $search . '%')
                        ->orWhere('pengarang', 'LIKE', '%' . $search . '%')
                        ->orWhere('penerbit', 'LIKE', '%' . $search . '%')
                        ->get();
        }

        return view('buku.public.index', compact('buku'));
    }
    
    public function showPublic($id)
    {   
        //Menampilkan Data Detail Buku Berdasarkan Buku yang Dipilih Di Halaman User
        return view('buku.public.show', ['buku' => Buku::findOrFail($id)]);
    }
    
    public function index(Request $request)
    {
        $search = $request->query('search');
    
        $bukus = Buku::orderBy('id', 'desc')
                      ->when($search, function ($query, $search) {
                          return $query->where('judul', 'like', '%'.$search.'%')
                                       ->orWhere('pengarang', 'like', '%'.$search.'%')
                                       ->orWhere('penerbit', 'like', '%'.$search.'%');
                      })
                      ->get();
    
        return view('buku.index', compact('bukus', 'search'));
    }
    
    public function create()
    {
        //Menuju Halaman Pembuat Buku Diadmin
        return view('buku.create');
    }


    public function store(Request $request)
    {
        // Validasi input field
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'penerbit' => 'required|max:255',
            'pengarang' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required',
        ]);

        // Proses upload image
        $path = $request->file('image')->store('public/images');

        // Simpan data buku ke database
        $buku = new Buku;
        $buku->judul = $validatedData['judul'];
        $buku->penerbit = $validatedData['penerbit'];
        $buku->pengarang = $validatedData['pengarang'];
        $buku->deskripsi = $validatedData['deskripsi'];
        $buku->image = $path;
        $buku->save();
        
        // Redirect ke halaman index user dengan alert succes   
        return redirect()->route('buku.index')->with('success', 'Buku Berhasil Di Tambahkan');
    
    }


    public function show($id)
    {
        //Melihat Detail Buku Diadmin
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }
    

    public function edit($id)
    {
        //Menuju Halaman update untuk mengedit buku
        $buku = Buku::findOrFail($id);
        return view('buku.update', compact('buku'));
    }


    public function update(Request $request, Buku $buku)
    {
        // Validasi Setiap Kolom
        $request->validate([
            'judul' => 'required',
            'penerbit' => 'required',
            'pengarang' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required|max:500',
        ]);
        // Proses edit gambar 
        if ($request->hasFile('image')) {
            if ($buku->image) {
                Storage::delete('public/'.$buku->image);
            }
            $image = $request->file('image')->store('public');
            $image = str_replace('public/', '', $image);
        } else {
            $image = $buku->image;
        }
        // Request isi data yang diedit  
        $buku->update([
            'judul' => $request->judul,
            'penerbit' => $request->penerbit,
            'pengarang' => $request->pengarang,
            'deskripsi' => $request->deskripsi,
            'image' => $image,
        ]);
        // Redirect ke halaman index user dengan alert succes   
        return redirect()->route('buku.index')
                        ->with('success', 'Data buku berhasil diperbarui');
    }


    public function destroy(Buku $buku)
    {
        // hapus file buku dari penyimpanan
        if ($buku->image) {
            Storage::delete('public/'.$buku->image);
        }

        // hapus data buku
        $buku->delete();

        // Redirect ke halaman index user dengan alert succes
        return redirect()->route('buku.index')->with('success', 'Buku Berhasil Dihapus');
    }

}