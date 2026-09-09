<div class="student-barcode text-center">

    <img
        src="{{ route('siswa.qr', $siswa) }}"
        alt="Barcode {{ $siswa->nisn }}"
        class="student-barcode-image">

    <div class="student-barcode-number">
        {{ $siswa->nisn }}
    </div>

</div>