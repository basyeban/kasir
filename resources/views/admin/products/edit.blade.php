<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Edit Produk') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Side: Basic Info -->
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="name" :value="__('Nama Produk')" class="font-bold text-gray-700 uppercase tracking-wider text-xs" />
                                    <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white transition-colors" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="category_id" :value="__('Kategori')" class="font-bold text-gray-700 uppercase tracking-wider text-xs" />
                                    <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-200 bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:bg-white transition-colors" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="price" :value="__('Harga (Rp)')" class="font-bold text-gray-700 uppercase tracking-wider text-xs" />
                                        <x-text-input id="price" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white transition-colors" type="number" name="price" :value="old('price', $product->price)" required />
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="stock" :value="__('Stok Saat Ini')" class="font-bold text-gray-700 uppercase tracking-wider text-xs" />
                                        <x-text-input id="stock" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white transition-colors" type="number" name="stock" :value="old('stock', $product->stock)" required />
                                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side: Image Upload -->
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="image" :value="__('Ubah Foto Produk')" class="font-bold text-gray-700 uppercase tracking-wider text-xs mb-1" />
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl bg-gray-50 hover:bg-white transition-colors cursor-pointer relative" onclick="document.getElementById('image').click()">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <span class="relative cursor-pointer rounded-md font-bold text-indigo-600 hover:text-indigo-500">
                                                    Klik untuk ganti foto
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto.</p>
                                        </div>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4 mt-4">
                                        @if($product->image)
                                            <div>
                                                <p class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Foto Saat Ini:</p>
                                                <img src="{{ asset('storage/' . $product->image) }}" class="h-40 w-full object-cover rounded-lg border border-gray-100 shadow-sm">
                                            </div>
                                        @endif
                                        <div id="image-preview" class="hidden">
                                            <p class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Foto Baru:</p>
                                            <img id="preview-img" class="h-40 w-full object-cover rounded-lg border border-indigo-200 shadow-sm">
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.products.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 uppercase tracking-widest transition-colors">
                                Batal
                            </a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 py-3 px-8 shadow-md">
                                {{ __('Update Produk') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('image-preview');
                const img = document.getElementById('preview-img');
                img.src = reader.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
