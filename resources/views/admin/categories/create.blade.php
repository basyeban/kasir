<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Tambah Kategori Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Nama Kategori')" class="font-bold text-gray-700 uppercase tracking-wider text-xs" />
                            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white transition-colors" type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama kategori (Contoh: Makanan, Elektronik, dll)..." />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="mt-2 text-xs text-gray-500 italic">* Slug akan otomatis dibuat dari nama kategori.</p>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.categories.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 uppercase tracking-widest transition-colors">
                                Batal
                            </a>
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 py-3 px-8 shadow-md">
                                {{ __('Simpan Kategori') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
