<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomizationToFootersTable extends Migration
{
    public function up()
    {
        Schema::table('footers', function (Blueprint $table) {
            $table->string('school_name')->nullable()->after('id');
            $table->string('tagline')->nullable()->after('school_name');
            $table->text('address')->nullable()->after('desc');
            $table->string('primary_color', 20)->default('#087f5b')->after('address');
            $table->string('secondary_color', 20)->default('#f59f00')->after('primary_color');
            $table->string('favicon')->nullable()->after('logo');
            $table->string('linkedin')->nullable()->after('twitter');
        });
    }

    public function down()
    {
        Schema::table('footers', function (Blueprint $table) {
            $table->dropColumn(['school_name','tagline','address','primary_color','secondary_color','favicon','linkedin']);
        });
    }
}
