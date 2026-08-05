<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePpdbContentsTable extends Migration
{
    public function up()
    {
        Schema::create('ppdb_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section', 30);
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('icon', 50)->default('check-circle');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['section', 'is_active', 'sort_order']);
        });

        $now = now();
        DB::table('ppdb_contents')->insert([
            ['section' => 'program', 'title' => 'Sains & Teknologi', 'content' => 'Pembelajaran sains, teknologi, literasi digital, dan proyek kreatif.', 'icon' => 'laptop', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'program', 'title' => 'Karakter Islami', 'content' => 'Pembiasaan ibadah, akhlak, kepemimpinan, dan nilai Kemuhammadiyahan.', 'icon' => 'heart', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'program', 'title' => 'Minat & Prestasi', 'content' => 'Pendampingan akademik, olahraga, seni, organisasi, dan ekstrakurikuler.', 'icon' => 'award', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'alur', 'title' => 'Buat Akun PPDB', 'content' => 'Calon murid membuat akun menggunakan email aktif dan nomor WhatsApp.', 'icon' => 'user-plus', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'alur', 'title' => 'Lengkapi Biodata', 'content' => 'Masuk ke dashboard lalu lengkapi data calon murid dan orang tua.', 'icon' => 'edit-3', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'alur', 'title' => 'Unggah Berkas', 'content' => 'Unggah seluruh dokumen persyaratan pada menu berkas PPDB.', 'icon' => 'upload-cloud', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'alur', 'title' => 'Verifikasi & Pengumuman', 'content' => 'Petugas memeriksa data dan mengumumkan hasil melalui dashboard.', 'icon' => 'check-square', 'sort_order' => 4, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'berkas', 'title' => 'Kartu Keluarga', 'content' => 'Salinan Kartu Keluarga yang terbaca jelas.', 'icon' => 'file-text', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'berkas', 'title' => 'Akta Kelahiran', 'content' => 'Salinan akta kelahiran calon murid.', 'icon' => 'file-text', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'berkas', 'title' => 'Rapor', 'content' => 'Salinan rapor terakhir sesuai ketentuan sekolah.', 'icon' => 'book-open', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'berkas', 'title' => 'Pas Foto', 'content' => 'Pas foto terbaru dengan tampilan rapi.', 'icon' => 'image', 'sort_order' => 4, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'informasi', 'title' => 'Pendaftaran Online', 'content' => 'Pendaftaran dan pengunggahan dokumen dilakukan melalui website PPDB ini.', 'icon' => 'globe', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'informasi', 'title' => 'Bantuan Petugas', 'content' => 'Hubungi sekolah apabila mengalami kendala saat pendaftaran atau unggah berkas.', 'icon' => 'help-circle', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('ppdb_contents');
    }
}
