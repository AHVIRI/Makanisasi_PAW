<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Makanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MakananController extends Controller
{
    public function create()
    {
        return view('admin.createMakanan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available' => 'required|boolean',
        ]);

        $makananData = [
            'nama_makanan' => $request->input('nama_makanan'),
            'deskripsi' => $request->input('deskripsi'),
            'kategori' => $request->input('kategori'),
            'price' => floatval(preg_replace('/[^\d.]/', '', $request->input('price'))),
            'is_available' => $request->boolean('is_available'),
        ];

        if ($request->hasFile('image')) {
            $uploadedFile = cloudinary()->upload($request->file('image')->getRealPath());
            $makananData['image'] = $uploadedFile->getSecurePath();
        }

        Makanan::create($makananData);
        // Flash message for success
        session()->flash('success', 'Makanan berhasil ditambahkan!');
        return redirect()->route('admin.index');
    }

    public function edit(Makanan $makanan)
    {
        return view('admin.editMakanan', compact('makanan'));
    }

    public function update(Request $request, Makanan $makanan)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available' => 'required|boolean',
        ]);

        $makananData = $request->only(['nama_makanan', 'deskripsi', 'kategori', 'is_available']);
        $makananData['price'] = floatval(preg_replace('/[^\d.]/', '', $request->input('price')));

        // Handle image upload
        if ($request->hasFile('image')) {
            // Store new image
            $uploadedFile = cloudinary()->upload($request->file('image')->getRealPath());
            $makananData['image'] = $uploadedFile->getSecurePath();
        }

        $makanan->update($makananData);
        // Flash message for success
        session()->flash('success', 'Makanan berhasil diperbarui!');
        return redirect()->route('admin.index');
    }

    public function destroy(Makanan $makanan)
    {
        $makanan->delete();

        session()->flash('success', 'Makanan berhasil dihapus!');

        return redirect()->route('admin.index');
    }
}
