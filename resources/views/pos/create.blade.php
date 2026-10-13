
@extends('layouts.app')

@section('title', 'Kasir')

@section('content')
    <h1 class="text-lg font-semibold mb-4">Transaksi Kasir</h1>

    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @error('items')
        <div class="mb-4 rounded-md bg-red-100 p-3 text-red-700">
            {{ $message }}
        </div>
    @enderror

    <div x-data="{
        cart: [],

        addToCart(id, name, price) {
            this.cart.push({
                product_id: id,
                name: name,
                price: Number(price),
                qty: 1
            });
        },

        removeFromCart(index) {
            this.cart.splice(index, 1);
        },

        subtotal() {
            return this.cart.reduce(
                (sum, item) => sum + (item.price * item.qty),
                0
            );
        }
    }">

        <div class="grid grid-cols-3 gap-4">
            @foreach ($products as $product)
                <div
                    class="product-card border rounded-md p-3 cursor-pointer hover:bg-slate-50 transition"
                    @click="addToCart(
                        {{ $product->id }},
                        {{ Illuminate\Support\Js::from($product->name) }},
                        {{ $product->price }}
                    )"
                >
                    <p class="font-medium">{{ $product->name }}</p>

                    <p class="text-sm text-slate-500">
                        Rp {{ number_format($product->price) }}
                    </p>

                    @if ($product->stock < 10)
                        <span class="inline-block mt-1 text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded">
                            Stok Menipis
                        </span>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

        <form
            action="{{ route('transactions.store') }}"
            method="POST"
            class="mt-4 border-t pt-3"
        >
            @csrf

            <h2 class="font-semibold mb-2">Keranjang Belanja</h2>

            <template x-for="(item, index) in cart" :key="index">
                <div class="flex items-center justify-between py-1">
                    <div>
                        <p x-text="item.name"></p>
                        <p
                            class="text-sm text-slate-500"
                            x-text="'Qty: ' + item.qty + ' × Rp ' + item.price.toLocaleString('id-ID')"
                        ></p>
                    </div>

                    <button
                        type="button"
                        class="text-xs text-red-600 hover:text-red-800 hover:underline"
                        @click="removeFromCart(index)"
                    >
                        Hapus
                    </button>

                    <input
                        type="hidden"
                        :name="`items[${index}][product_id]`"
                        :value="item.product_id"
                    >

                    <input
                        type="hidden"
                        :name="`items[${index}][qty]`"
                        :value="item.qty"
                    >
                </div>
            </template>

            <p class="font-semibold mt-2">
                Subtotal: Rp
                <span x-text="subtotal().toLocaleString('id-ID')"></span>
            </p>

            <button
                type="submit"
                class="mt-3 rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
            >
                Bayar
            </button>
        </form>
    </div>

    @vite('resources/js/pos.js')
@endsection
