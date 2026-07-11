<x-app-layout>

    <div class="flex justify-center items-start p-3 sm:p-6 lg:p-10 min-h-screen">
        <div class="bg-[#EADCC6] shadow-2xl rounded-[28px] w-full max-w-2xl overflow-hidden">

            {{-- ===== Header ===== --}}
            <div class="flex justify-between items-center bg-[#1E3A5F] px-4 sm:px-8 py-5 sm:py-6">
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('penghuni.dashboard') }}"
                       class="hover:opacity-80 text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 sm:w-7 h-6 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="font-bold text-white text-lg sm:text-2xl tracking-wide">Isi Keluhan</h1>
                </div>

                <button type="button" class="relative hover:opacity-80 text-white transition" title="Notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 sm:w-7 h-6 sm:h-7">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                    </svg>
                    <span class="top-0 right-0 absolute bg-red-500 rounded-full ring-[#1E3A5F] ring-2 w-2.5 h-2.5"></span>
                </button>
            </div>

            {{-- ===== Content ===== --}}
            <div class="p-4 sm:p-8">

                @if (session('success'))
                    <div class="bg-green-100 mb-6 px-4 py-3 rounded-xl font-medium text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white shadow-md p-5 sm:p-7 rounded-2xl">
                    <h2 class="mb-5 font-bold text-[#1E3A5F] text-lg sm:text-xl">Ajukan Pengaduan</h2>

                    <form method="POST" action="{{ route('penghuni.pengaduan.store') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div>
                            <label for="kategori" class="block mb-1.5 font-semibold text-gray-700 text-sm">Kategori Kendala</label>
                            <input type="text" name="kategori" id="kategori" value="{{ old('kategori') }}" required
                                list="kategori-options" placeholder="Pilih atau ketik kategori"
                                class="border-gray-300 focus:border-[#1E3A5F] rounded-xl focus:ring-[#1E3A5F] w-full text-sm @error('kategori') border-red-400 @enderror">
                            <datalist id="kategori-options">
                                <option value="Kebersihan"></option>
                                <option value="Fasilitas Rusak"></option>
                                <option value="Kebisingan"></option>
                                <option value="Keamanan"></option>
                                <option value="Air / Listrik"></option>
                                <option value="Lainnya"></option>
                            </datalist>
                            @error('kategori')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deskripsi" class="block mb-1.5 font-semibold text-gray-700 text-sm">Deskripsi Detail Keluhan</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" required placeholder="Jelaskan keluhan kamu secara detail"
                                class="border-gray-300 focus:border-[#1E3A5F] rounded-xl focus:ring-[#1E3A5F] w-full text-sm @error('deskripsi') border-red-400 @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="gap-4 grid grid-cols-1 sm:grid-cols-2">
                            <div>
                                <label for="tanggal" class="block mb-1.5 font-semibold text-gray-700 text-sm">Tanggal Kejadian</label>
                                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required
                                    class="border-gray-300 focus:border-[#1E3A5F] rounded-xl focus:ring-[#1E3A5F] w-full text-sm @error('tanggal') border-red-400 @enderror">
                                @error('tanggal')
                                    <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kamar" class="block mb-1.5 font-semibold text-gray-700 text-sm">Nomor Kamar</label>
                                <input type="text" name="kamar" id="kamar" value="{{ old('kamar') }}" required placeholder="Contoh: A001"
                                    class="border-gray-300 focus:border-[#1E3A5F] rounded-xl focus:ring-[#1E3A5F] w-full text-sm @error('kamar') border-red-400 @enderror">
                                @error('kamar')
                                    <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div x-data="{ fileName: '' }">
                            <label class="block mb-1.5 font-semibold text-gray-700 text-sm">Upload Bukti <span class="font-normal text-gray-400">(opsional)</span></label>
                            <label for="bukti"
                                class="flex justify-center items-center bg-white hover:bg-gray-50 px-4 py-2.5 border border-gray-300 rounded-xl w-full text-gray-500 text-sm text-center transition cursor-pointer">
                                <span x-text="fileName || 'Pilih File'"></span>
                            </label>
                            <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                                @change="fileName = $event.target.files[0]?.name ?? ''">
                            <p class="mt-1 text-gray-400 text-xs">Format JPG, PNG, atau PDF, maksimal 4MB.</p>
                            @error('bukti')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-[#1E3A5F] hover:bg-[#1E3A5F]/90 shadow-sm px-4 py-3 rounded-xl w-full font-semibold text-white text-sm transition">
                            Kirim Laporan Pengaduan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>