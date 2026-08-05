<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ActivateExistingVideos extends Migration
{
    public function up()
    {
        // Penyesuaian satu kali: seluruh video lama dibuat aktif.
        // Sesudah migrasi, admin tetap dapat menonaktifkan video tertentu.
        DB::table('videos')->update(['is_active' => 1]);
    }

    public function down()
    {
        // Status yang dipilih admin setelah migrasi tidak boleh ditimpa saat rollback.
    }
}
