<div class="form-group">
    <label for="nama_produk">Nama produk</label>
    <input
        id="nama_produk"
        name="nama_produk"
        type="text"
        value="{{ old('nama_produk', $produk->nama_produk ?? '') }}"
        class="form-control @error('nama_produk') is-invalid @enderror"
    >
    @error('nama_produk')
        <small class="error">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="deskripsi">Deskripsi</label>
    <textarea
        id="deskripsi"
        name="deskripsi"
        rows="5"
        class="form-control @error('deskripsi') is-invalid @enderror"
    >{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
    @error('deskripsi')
        <small class="error">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="harga">Harga</label>
    <input
        id="harga"
        name="harga"
        type="number"
        min="0"
        value="{{ old('harga', $produk->harga ?? '') }}"
        class="form-control @error('harga') is-invalid @enderror"
    >
    @error('harga')
        <small class="error">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="gambar">Gambar Produk (opsional)</label>
    
    <!-- Menampilkan gambar saat ini jika ada (berguna saat di halaman Edit) -->
    @if(isset($produk) && $produk->gambar)
        <div style="margin-bottom: 12px;">
            <small style="display: block; margin-bottom: 4px; color: var(--muted);">Gambar saat ini:</small>
            <img src="{{ asset('storage/' . $produk->gambar) }}" 
                 alt="Preview" 
                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
        </div>
    @endif

    <!-- Input file -->
    <input
        id="gambar"
        name="gambar"
        type="file"
        accept="image/*"
        class="form-control @error('gambar') is-invalid @enderror"
    >
    @error('gambar')
        <small class="error">{{ $message }}</small>
    @enderror
</div>

<div class="form-actions">
    <button class="btn" type="submit">{{ $tombol }}</button>
    <a class="btn btn-secondary" href="{{ route('produk.index') }}">
        Batal
    </a>
</div>