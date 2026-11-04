<div class="form-grid">
    <div class="form-group">
        <label>Kategori</label>
        <select name="category_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $item?->category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Judul Buku</label>
        <input name="name" class="form-control"
               value="{{ old('name', $item?->name) }}" required>
    </div>

    <div class="form-group">
        <label>Kode Buku</label>
        <input name="code" class="form-control"
               value="{{ old('code', $item?->code) }}" required>
    </div>

    <div class="form-group">
        <label>Jumlah Stok</label>
        <input type="number" name="quantity" class="form-control" min="0"
               value="{{ old('quantity', $item?->quantity ?? 0) }}" required>
    </div>

    <div class="form-group">
        <label>Harga</label>
        <input type="number" name="price" class="form-control" min="0" step="0.01"
               value="{{ old('price', $item?->price ?? 0) }}" required>
    </div>

    <div class="form-group full">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control">{{ old('description', $item?->description) }}</textarea>
    </div>
</div>
