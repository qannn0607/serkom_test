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
                        <th>Kode Produk</th>
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
                            <td>{{ $produk->kode_produk }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-small btn-edit" href="{{ route('produk.edit', $produk) }}">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('produk.destroy', $produk) }}" class="form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button class="btn btn-small btn-danger btn-trigger-hapus" type="button">
                                            Hapus
                                        </button>

                                        <div class="modal-overlay">
                                            <div class="modal-box">
                                                <h3>Hapus Produk?</h3>
                                                <p>Produk yang sudah dihapus tidak dapat dikembalikan lagi. Yakin ingin melanjutkan?</p>
                                                <div class="modal-actions">
                                                    <button type="button" class="btn btn-secondary btn-batal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                Belum ada produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    document.querySelectorAll('.form-hapus').forEach(form => {
        const triggerBtn = form.querySelector('.btn-trigger-hapus');
        const modal = form.querySelector('.modal-overlay');
        const cancelBtn = form.querySelector('.btn-batal');

        // Klik tombol Hapus di dalam td -> munculkan notif
        triggerBtn.addEventListener('click', () => modal.classList.add('show'));

        // Klik Batal -> tutup notif
        cancelBtn.addEventListener('click', () => modal.classList.remove('show'));

        // Klik area luar kotak -> tutup notif
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.remove('show');
        });
    });
</script>
@endsection