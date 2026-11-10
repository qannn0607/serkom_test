@extends('layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<main class="admin-page">
    <div class="container admin-container wide">
        <div class="page-heading">
            <div>
                <span class="eyebrow">Dashboard sederhana</span>
                <h1 class="h1-produk">Kelola Produk</h1>
            </div>
            <div class="heading-actions">
                <a class="btn btn-secondary" href="{{ route('landing') }}">
                    Lihat Landing Page
                </a>
                <a class="btn" href="{{ route('produk.create') }}">
                    Tambah Produk
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $produk->nama_produk }}</strong>
                                <small>{{ $produk->deskripsi }}</small>
                            </td>
                            <td>
                                Rp{{ number_format($produk->harga, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($produk->gambar)
                                    <!-- Sesuaikan 'storage/' dengan nama folder tempat Anda menyimpan gambar -->
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" 
                                        alt="{{ $produk->nama_produk }}" 
                                        style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <!-- Menampilkan gambar default jika produk tidak punya gambar -->
                                    <img src="{{ asset('images/kopi-default.jpg') }}" 
                                        alt="Default" 
                                        style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-small btn-edit" href="{{ route('produk.edit', $produk) }}">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('produk.destroy', $produk) }}" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-small btn-danger" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>                        
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                Belum ada produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection