<x-app-layout>

    <div class="space-y-6 mx-auto px-6 pt-6 pb-12 max-w-5xl">

        <div class="py-1 pl-4 border-primary border-l-4">
            <p class="font-bold text-grayCustom-800 text-base">Isi Keluhan</p>
            <p class="mt-0.5 text-grayCustom-500 text-xs md:text-sm">
                Sampaikan kendala yang kamu alami selama tinggal, tim pengelola akan segera menindaklanjuti.
            </p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 px-4 py-3 rounded-xl font-medium text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-lg p-6 sm:p-8 border border-grayCustom-100 rounded-2xl">
            <form method="POST" action="{{ route('penghuni.pengaduan.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label for="kategori" class="block mb-1.5 font-semibold text-gray-700 text-sm">Kategori Kendala</label>
                    <input type="text" name="kategori" id="kategori" value="{{ old('kategori') }}" required
                        list="kategori-options" placeholder="Pilih atau ketik kategori"
                        class="border-gray-300 focus:border-primary rounded-xl focus:ring-primary w-full text-sm @error('kategori') border-red-400 @enderror">
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
                    <textarea name="deskripsi" id="deskripsi" rows="4" required placeholder="Jelaskan keluhan kamu secara detail"
                        class="border-gray-300 focus:border-primary rounded-xl focus:ring-primary w-full text-sm @error('deskripsi') border-red-400 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <div class="gap-4 grid grid-cols-1 sm:grid-cols-2">
                    <div>
                        <label for="tanggal" class="block mb-1.5 font-semibold text-gray-700 text-sm">Tanggal Kejadian</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required
                            class="border-gray-300 focus:border-primary rounded-xl focus:ring-primary w-full text-sm @error('tanggal') border-red-400 @enderror">
                        @error('tanggal')
                            <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kamar" class="block mb-1.5 font-semibold text-gray-700 text-sm">Nomor Kamar</label>
                        <input type="text" name="kamar" id="kamar" value="{{ old('kamar') }}" required placeholder="Contoh: A001"
                            class="border-gray-300 focus:border-primary rounded-xl focus:ring-primary w-full text-sm @error('kamar') border-red-400 @enderror">
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
                    class="bg-primary hover:bg-primary/90 shadow-sm px-4 py-3 rounded-xl w-full font-semibold text-white text-sm transition">
                    Kirim Laporan Pengaduan
                </button>
            </form>
        </div>
    </div>

</x-app-layout>