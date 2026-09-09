<?php

namespace App\Helpers;

use App\Models\Siswa;
use Illuminate\Support\Facades\File;
use Milon\Barcode\DNS1D;

class QrCodeHelper
{
    /**
     * Generate barcode linear C128 dari NISN siswa.
     */
    public static function generate(Siswa $siswa): string
    {
        $nisn = trim($siswa->nisn);

        if ($nisn === '') {
            throw new \Exception('NISN siswa tidak tersedia.');
        }

        // Folder penyimpanan
        $folder = public_path('storage/barcodes/siswa');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $filename = $nisn . '.png';
        $path = $folder . DIRECTORY_SEPARATOR . $filename;

        // =========================================================
        // GENERATE BARCODE TANPA TEKS
        // =========================================================

        $generator = new DNS1D();

        $barcodeBase64 = $generator->getBarcodePNG(
            $nisn,
            'C128',
            2,
            55,
            [0, 0, 0],
            false
        );

        $barcodeData = base64_decode($barcodeBase64);

        $barcodeImage = imagecreatefromstring($barcodeData);

        if (!$barcodeImage) {
            throw new \Exception('Gagal membuat gambar barcode.');
        }

        $barcodeWidth = imagesx($barcodeImage);
        $barcodeHeight = imagesy($barcodeImage);

        // =========================================================
        // CANVAS PUTIH
        // =========================================================

        $paddingX = 10;
        $paddingTop = 10;
        $paddingBottom = 28;

        $canvasWidth = $barcodeWidth + ($paddingX * 2);
        $canvasHeight = $barcodeHeight + $paddingTop + $paddingBottom;

        $canvas = imagecreatetruecolor(
            $canvasWidth,
            $canvasHeight
        );

        // Background PUTIH SOLID
        $white = imagecolorallocate(
            $canvas,
            255,
            255,
            255
        );

        imagefill(
            $canvas,
            0,
            0,
            $white
        );

        // =========================================================
        // TEMPEL BARCODE
        // =========================================================

        imagecopy(
            $canvas,
            $barcodeImage,
            $paddingX,
            $paddingTop,
            0,
            0,
            $barcodeWidth,
            $barcodeHeight
        );

        // =========================================================
        // TULIS NISN DI BAWAH BARCODE
        // =========================================================

        $black = imagecolorallocate(
            $canvas,
            0,
            0,
            0
        );

        $font = 3;

        $textWidth = imagefontwidth($font) * strlen($nisn);
        $textHeight = imagefontheight($font);

        $textX = (int) (($canvasWidth - $textWidth) / 2);

        $textY = $paddingTop
            + $barcodeHeight
            + 5;

        imagestring(
            $canvas,
            $font,
            $textX,
            $textY,
            $nisn,
            $black
        );

        // =========================================================
        // SIMPAN PNG
        // =========================================================

        imagepng(
            $canvas,
            $path,
            6
        );

        imagedestroy($barcodeImage);
        imagedestroy($canvas);

        return 'storage/barcodes/siswa/' . $filename;
    }
}