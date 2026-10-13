
@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <h1 class="text-lg font-semibold mb-4">Edit Produk</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Produk</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $product->name) }}"
                class="w-full border rounded-md p-2"
                required
            >
            @error('name')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category_id">Kategori</label>
            <select
                id="category_id"
                name="category_id"
                class="w-full border rounded-md p-2"
                required
            >
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(old('category_id', $product->category_id) == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price">Harga</label>
            <input
                type="number"
                id="price"
                name="price"
                value="{{ old('price', $product->price) }}"
                min="0"
                class="w-full border rounded-md p-2"
                required
            >
            @error('price')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="stock">Stok</label>
            <input
                type="number"
                id="stock"
                name="stock"
                value="{{ old('stock', $product->stock) }}"
                min="0"
                class="w-full border rounded-md p-2"
                required
            >
            @error('stock')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-white">
            Simpan Perubahan
        </button>

        <a href="{{ route('products.index') }}" class="ml-2 text-gray-600">
            Batal
        </a>
    </form>
@endsection
