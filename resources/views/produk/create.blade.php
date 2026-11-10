@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<main class="admin-page">
    <div class="container admin-container">
        <div class="page-heading">
            <div>
                <span class="eyebrow">Pengelolaan produk</span>
                <h1>Tambah Produk</h1>
            </div>
        </div>

        <!-- TAMBAHKAN enctype="multipart/form-data" DI SINI -->
        <form method="POST" action="{{ route('produk.store') }}"
              class="form-card" enctype="multipart/form-data">
            @csrf
            @include('produk.form', ['tombol' => 'Simpan Produk'])
        </form>
    </div>
</main>
@endsection