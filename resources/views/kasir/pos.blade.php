<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Point of Sale (Penjualan)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Product List -->
                <div class="lg:w-2/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium mb-4">Pilih Produk</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($products as $product)
                                <div class="border rounded-lg p-4 flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $product->name }}</h4>
                                        <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                                        <p class="text-indigo-600 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <form action="{{ route('kasir.cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Tambah
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Shopping Cart -->
                <div class="lg:w-1/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-medium mb-4">Keranjang</h3>
                        @if(count($cart) > 0)
                            <div class="space-y-4 mb-6">
                                @foreach($cart as $id => $details)
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <div>
                                            <p class="font-bold">{{ $details['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $details['quantity'] }} x Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <p class="font-semibold text-sm">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                                            <form action="{{ route('kasir.cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between text-xl font-bold mb-4">
                                    <span>Total</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>

                                <form action="{{ route('kasir.checkout') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="payment_amount" class="block text-sm font-medium text-gray-700">Jumlah Bayar</label>
                                        <input type="number" name="payment_amount" id="payment_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    </div>
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Proses Bayar (Checkout)
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-10">Keranjang masih kosong.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
