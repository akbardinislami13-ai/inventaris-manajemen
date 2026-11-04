<div class="form-grid">
    <div class="form-group">
        <label>Nama Kategori</label>
        <input name="name" class="form-control"
               value="{{ old('name', $category->name ?? '') }}"
               maxlength="255" required>
    </div>

    <div class="form-group full">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control">{{ old('description', $category->description ?? '') }}</textarea>
    </div>
</div>
