<div class="w-full">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">
        Data Diri Penghuni
    </h2>

    <form method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nama Lengkap
            </label>
            <input
                type="text"
                name="nama"
                placeholder="Masukkan nama lengkap"
                class="w-full rounded-lg border-gray-300 focus:border-[#1E4363] focus:ring-[#1E4363]">
        </div>

        {{-- Tanggal Lahir & Jenis Kelamin --}}
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal Lahir
                </label>
                <input
                    type="date"
                    name="tanggal_lahir"
                    class="w-full rounded-lg border-gray-300 focus:border-[#1E4363] focus:ring-[#1E4363]">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jenis Kelamin
                </label>
                <div class="flex gap-6 mt-3">
                    <label class="flex items-center gap-2">
                        <input
                            type="radio"
                            name="jenis_kelamin"
                            value="Laki-laki">
                        <span>Laki-laki</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input
                            type="radio"
                            name="jenis_kelamin"
                            value="Perempuan">
                        <span>Perempuan</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Nomor HP & Email --}}
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nomor Telepon
                </label>
                <input
                    type="text"
                    name="no_hp"
                    placeholder="08xxxxxxxxxx"
                    class="w-full rounded-lg border-gray-300 focus:border-[#1E4363] focus:ring-[#1E4363]">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    placeholder="user@email.com"
                    class="w-full rounded-lg border-gray-300 focus:border-[#1E4363] focus:ring-[#1E4363]">
            </div>
        </div>

        {{-- Alamat --}}
        <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Alamat Lengkap
            </label>
            <textarea
                rows="4"
                name="alamat"
                placeholder="Masukkan alamat lengkap..."
                class="w-full rounded-lg border-gray-300 resize-none focus:border-[#1E4363] focus:ring-[#1E4363]"></textarea>
        </div>

        {{-- Informasi Kamar --}}
        <div class="border-t pt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">
                Informasi Kamar
            </h3>

            <div class="grid md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Nomor Kamar
                    </label>
                    <div class="bg-gray-100 rounded-lg p-3">
                        A001
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Check In
                    </label>
                    <div class="bg-gray-100 rounded-lg p-3">
                        17 Juli 2025
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Status
                    </label>
                    <div class="bg-green-100 text-green-700 font-semibold rounded-lg p-3">
                        Active
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="mt-10">
            <button
                type="submit"
                class="w-full bg-[#1E4363] hover:bg-[#16324b] text-white font-semibold py-3 rounded-lg transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<script>
const foto = document.getElementById('foto');
foto.addEventListener('change', function(){
    const file = this.files[0];
    if(!file) return;
    const reader = new FileReader();
    reader.onload = function(e){
        document.getElementById('preview-image').src = e.target.result;
        document.getElementById('preview-container').classList.remove('hidden');
        document.getElementById('upload-icon').classList.add('hidden');
    }

    reader.readAsDataURL(file);

});
</script>
