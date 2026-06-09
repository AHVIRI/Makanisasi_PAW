<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Minuman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MinumanController extends Controller
{
    public function create()
    {
        return view('admin.createMinuman');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_minuman' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available' => 'required|boolean',
        ]);

        $minumanData = [
            'nama_minuman' => $request->input('nama_minuman'),
            'deskripsi' => $request->input('deskripsi'),
            'kategori' => $request->input('kategori'),
            'price' => floatval(preg_replace('/[^\d.]/', '', $request->input('price'))),
            'is_available' => $request->boolean('is_available'),
        ];

        if ($request->hasFile('image')) {
            $uploadedFile = cloudinary()->upload($request->file('image')->getRealPath());
            $minumanData['image'] = $uploadedFile->getSecurePath();
        }

        Minuman::create($minumanData);
        // Flash message for success
        session()->flash('success', 'Minuman berhasil ditambahkan!');
        return redirect()->route('admin.index');
    }

    public function edit(Minuman $minuman)
    {
        return view('admin.editMinuman', compact('minuman'));
    }

    public function update(Request $request, Minuman $minuman)
    {
        $request->validate([
            'nama_minuman' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available' => 'required|boolean',
        ]);

        $minumanData = $request->only(['nama_minuman', 'deskripsi', 'kategori', 'is_available']);
        $minumanData['price'] = floatval(preg_replace('/[^\d.]/', '', $request->input('price')));

        // Handle image upload
        if ($request->hasFile('image')) {
            // Store new image
            $uploadedFile = cloudinary()->upload($request->file('image')->getRealPath());
            $minumanData['image'] = $uploadedFile->getSecurePath();
        }

        $minuman->update($minumanData);
        // Flash message for success
        session()->flash('success', 'Minuman berhasil diperbarui!');
        return redirect()->route('admin.index');
    }

    public function destroy(Minuman $minuman)
    {
        $minuman->delete();

        session()->flash('success', 'Minuman berhasil dihapus!');

        return redirect()->route('admin.index');
    }
}
