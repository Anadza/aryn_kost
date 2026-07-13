<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('penghuni.dashboard') }}"
                class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-500 hover:text-primary transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h2 class="font-bold text-primary text-xl tracking-tight">
                Upload Pembayaran
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6 mx-auto px-6 pt-6 pb-12 max-w-5xl">

        <div class="py-1 pl-4 border-primary border-l-4">
            <p class="font-bold text-grayCustom-800 text-base">Informasi Tagihan</p>
            <p class="mt-0.5 text-grayCustom-500 text-xs md:text-sm">
                Harap melunasi tagihan tepat waktu dan mengunggah bukti pembayaran agar status hunian Anda langsung
                diperbarui.
            </p>
        </div>

        @if ($tagihan)
            <div class="gap-6 grid grid-cols-1 md:grid-cols-2">

                {{-- Tagihan Bulan Ini --}}
                <div class="bg-white shadow-lg p-6 border border-grayCustom-100 rounded-2xl">
                    <h3 class="mb-5 pb-3 border-grayCustom-100 border-b font-bold text-primary text-lg">Tagihan Bulan
                        Ini</h3>

                    <div class="flex justify-between items-center mb-4">
                        <span class="font-bold text-grayCustom-800 text-base">{{ $tagihan->bulan_tagihan }}</span>
                        <span
                            class="text-xs font-semibold px-3 py-1 rounded-full
                            @if ($tagihan->status_pembayaran === 'Belum Dibayar') bg-red-100 text-red-600
                            @elseif($tagihan->status_pembayaran === 'Menunggu Konfirmasi') bg-warning-100 text-warning-700
                            @else bg-success-100 text-success-700 @endif">
                            {{ $tagihan->status_pembayaran }}
                        </span>
                    </div>

                    <p class="mb-5 font-bold text-grayCustom-900 text-3xl tracking-tight">
                        Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                    </p>

                    <div class="space-y-2.5 bg-grayCustom-5/50 p-3 border border-grayCustom-100/50 rounded-xl text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-grayCustom-400">Tanggal Jatuh Tempo</span>
                            <span class="font-bold text-red-500">
                                {{ $tagihan->tanggal_jatuh_tempo->locale('id')->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-grayCustom-400">Nomor Tagihan</span>
                            <span class="font-medium text-grayCustom-600">{{ $tagihan->nomor_tagihan }}</span>
                        </div>
                    </div>
                </div>

                {{-- Petunjuk Pembayaran --}}
                <div class="bg-white shadow-lg p-6 border border-grayCustom-100 rounded-2xl">
                    <h3 class="mb-5 pb-3 border-grayCustom-100 border-b font-bold text-primary text-lg">Petunjuk
                        Pembayaran</h3>

                    <div
                        class="flex items-center gap-3 bg-grayCustom-5 mb-4 p-3 border border-grayCustom-100 rounded-xl">
                        <div
                            class="flex justify-center items-center bg-blue-800 shadow-sm rounded-lg w-10 h-10 shrink-0">
                            <span class="font-bold text-[9px] text-white text-center leading-tight">BCA<br>mobile</span>
                        </div>
                        <div>
                            <p class="font-bold text-grayCustom-800 text-sm leading-tight">Bank BCA a.n arynKost</p>
                            <p class="mt-0.5 font-mono text-grayCustom-500 text-xs">123 456 7890</p>
                        </div>
                    </div>

                    <ol class="space-y-2 pl-1 text-grayCustom-600 text-sm list-decimal list-inside">
                        <li>Transfer sesuai nominal tagihan Anda</li>
                        <li>Ambil tangkapan layar (screenshot) bukti transfer</li>
                        <li>Unggah berkas bukti pada kolom yang tersedia di bawah</li>
                        <li>Pembayaran diproses dalam waktu maksimal 1x24 jam</li>
                    </ol>
                </div>
            </div>

            {{-- Upload Bukti Pembayaran --}}
            <div class="bg-white shadow-lg p-6 border border-grayCustom-100 rounded-2xl" x-data="{
                file: null,
                fileName: '',
                isDragging: false,
                handleFile(e) {
                    const f = e.target.files[0];
                    if (f) {
                        this.file = f;
                        this.fileName = f.name;
                    }
                },
                handleDrop(e) {
                    this.isDragging = false;
                    const f = e.dataTransfer.files[0];
                    if (f) {
                        this.file = f;
                        this.fileName = f.name;
                        const dt = new DataTransfer();
                        dt.items.add(f);
                        this.$refs.fileInput.files = dt.files;
                    }
                }
            }">
                <h3 class="mb-4 font-bold text-primary text-lg">Upload Bukti Pembayaran Disini!</h3>

                <form action="{{ route('penghuni.pembayaran.upload.post', $tagihan->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <input type="file" name="bukti_pembayaran" x-ref="fileInput" accept=".png,.jpg,.jpeg,.pdf"
                        class="hidden" @change="handleFile($event)">

                    <div @click="$refs.fileInput.click()" @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                        :class="isDragging ? 'border-primary bg-primary/5' : 'border-grayCustom-200 hover:border-primary/50'"
                        class="flex flex-col justify-center items-center bg-grayCustom-5/30 py-12 border-2 border-dashed rounded-xl transition cursor-pointer">

                        <div
                            class="flex justify-center items-center bg-primary/10 mb-3 rounded-xl w-12 h-12 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                            </svg>
                        </div>

                        <p class="font-bold text-grayCustom-700 text-sm" x-show="!fileName">Klik untuk mencari dokumen
                            atau seret kemari</p>
                        <p class="max-w-xs font-bold text-primary text-sm truncate" x-show="fileName" x-text="fileName"
                            x-cloak></p>
                        <p class="mt-1 text-grayCustom-400 text-xs">Mendukung format PNG, JPG, atau PDF (Maks. 5MB)</p>
                    </div>

                    {{-- Tombol Aksi Bawah --}}
                    <div class="flex sm:flex-row flex-col gap-3 pt-2">
                        <button type="button" @click="$refs.fileInput.click()"
                            class="hover:bg-grayCustom-50 px-4 py-2.5 border border-grayCustom-200 rounded-xl sm:w-44 font-semibold text-grayCustom-600 text-sm text-center transition">
                            Pilih File Baru
                        </button>

                        <button type="submit" :disabled="!file"
                            :class="file ? 'bg-primary text-white hover:bg-primary/90 shadow-md cursor-pointer' :
                                'bg-grayCustom-100 text-grayCustom-400 cursor-not-allowed'"
                            class="flex-1 px-6 py-2.5 rounded-xl font-semibold text-sm text-center transition">
                            Kirim Bukti Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div
                class="bg-white shadow-lg p-12 border border-grayCustom-100 rounded-2xl text-grayCustom-400 text-sm text-center">
                Belum ada info tagihan aktif untuk periode bulan ini.
            </div>
        @endif

    </div>

</x-app-layout>
