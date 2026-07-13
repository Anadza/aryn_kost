<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-[#1E3A5F] mb-1">Form Pengajuan Keluhan</h2>
            <p class="text-xs text-gray-500 mb-6">Laporkan kerusakan kamar agar segera ditangani oleh pengelola.</p>

            <!-- Pastikan ada enctype="multipart/form-data" untuk upload file -->
            <form method="POST" action="{{ route('penghuni.pengaduan.store') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Input Tanggal (Otomatis Hari Ini & Readonly) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pengaduan</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-[#1E3A5F] focus:ring-[#1E3A5F]">
                    </div>

                    <!-- Input Nomor Kamar -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Kamar</label>
                        <input type="text" name="kamar" required placeholder="Contoh: A002"
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-[#1E3A5F] focus:ring-[#1E3A5F]">
                    </div>
                </div>

                <!-- Pilihan Kategori -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Masalah</label>
                    <select name="kategori" required
                        class="w-full rounded-xl border-gray-200 text-sm focus:border-[#1E3A5F] focus:ring-[#1E3A5F]">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Fasilitas Kamar">Fasilitas Kamar (Kasur, Lemari, dll)</option>
                        <option value="Air / Listrik">Masalah Air / Listrik</option>
                        <option value="Fasilitas Umum">Fasilitas Umum Kos</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Deskripsi Keluhan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jelaskan Detail Keluhan</label>
                    <textarea name="deskripsi" rows="4" required placeholder="Contoh: Lampu kamar mandi mati atau kran air bocor..."
                        class="w-full rounded-xl border-gray-200 text-sm focus:border-[#1E3A5F] focus:ring-[#1E3A5F]"></textarea>
                </div>

                <!-- Upload Bukti Foto (Opsional) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Bukti Kerusakan <span
                            class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="file" name="bukti" accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                    <p class="text-[11px] text-gray-400 mt-1">*Format gambar (jpg, jpeg, png)</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('penghuni.pengaduan.index') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 transition">Batal</a>
                    <button type="submit"
                        class="bg-[#1E3A5F] hover:bg-[#1E3A5F]/90 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">Kirim
                        Laporan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
