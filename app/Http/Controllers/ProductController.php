<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk mengelola file

class ProductController extends Controller
{
    public function landing(): View
    {
        $products = Product::query()->latest()->get();

        return view('landing', compact('products'));
    }

    public function index(): View
    {
        $products = Product::query()->latest()->get();

        return view('produk.index', compact('products'));
    }

    public function create(): View
    {
        return view('produk.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'nama_produk' => ['required', 'string', 'max:100'],
                'deskripsi' => ['required', 'string'],
                'harga' => ['required', 'integer', 'min:0'],
                // Ubah validasi gambar
                'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            ],
            $this->validationMessages()
        );

        // Logika upload gambar
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke folder storage/app/public/produk
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Product::query()->create($validated);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $produk): View
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Product $produk): RedirectResponse 
    {
        $validated = $request->validate(
            [
                'nama_produk' => ['required', 'string', 'max:100'],
                'deskripsi' => ['required', 'string'],
                'harga' => ['required', 'integer', 'min:0'],
                // Ubah validasi gambar
                'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            ],
            $this->validationMessages()
        );

        // Logika update gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            
            // Simpan gambar baru
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($validated);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $produk): RedirectResponse
    {
        // Hapus file gambar dari storage sebelum produk dihapus dari database
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function validationMessages(): array
    {
        return [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama maksimal 100 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa bilangan bulat.',
            'harga.min' => 'Harga tidak boleh negatif.',
            // Pesan error khusus gambar
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}