<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mini POS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <h1 class="text-4xl font-bold text-center text-gray-900 mb-10">Mini POS - Katalog Produk</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
                        @else
                            <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        <div class="p-6 flex-grow">
                            <span class="text-xs font-semibold text-blue-500 uppercase tracking-wide">{{ $product->category->name }}</span>
                            <h2 class="text-xl font-bold text-gray-900 mt-2">{{ $product->name }}</h2>
                            <p class="text-gray-600 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-6 border-t border-gray-100 flex items-center justify-between">
                            @if($product->stock > 0)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Tersedia (Sisa: {{ $product->stock }})</span>
                                <!-- <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded text-sm">Beli</button> -->
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Habis</span>
                                <!-- <button class="bg-gray-400 text-white font-bold py-1 px-4 rounded text-sm cursor-not-allowed" disabled>Beli</button> -->
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
