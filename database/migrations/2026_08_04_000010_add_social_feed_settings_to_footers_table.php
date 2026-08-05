<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialFeedSettingsToFootersTable extends Migration
{
    public function up()
    {
        $columns = [
            'tiktok' => function (Blueprint $table) {
                $table->string('tiktok')->nullable()->after('instagram');
            },
            'instagram_handle' => function (Blueprint $table) {
                $table->string('instagram_handle', 80)->nullable()->after('youtube');
            },
            'tiktok_handle' => function (Blueprint $table) {
                $table->string('tiktok_handle', 80)->nullable()->after('instagram_handle');
            },
            'youtube_handle' => function (Blueprint $table) {
                $table->string('youtube_handle', 80)->nullable()->after('tiktok_handle');
            },
            'instagram_embed_url' => function (Blueprint $table) {
                $table->text('instagram_embed_url')->nullable()->after('youtube_handle');
            },
            'tiktok_embed_url' => function (Blueprint $table) {
                $table->text('tiktok_embed_url')->nullable()->after('instagram_embed_url');
            },
            'youtube_embed_url' => function (Blueprint $table) {
                $table->text('youtube_embed_url')->nullable()->after('tiktok_embed_url');
            },
        ];

        foreach ($columns as $column => $definition) {
            if (!Schema::hasColumn('footers', $column)) {
                Schema::table('footers', $definition);
            }
        }
    }

    public function down()
    {
        $columns = [
            'tiktok',
            'instagram_handle',
            'tiktok_handle',
            'youtube_handle',
            'instagram_embed_url',
            'tiktok_embed_url',
            'youtube_embed_url',
        ];
        $existingColumns = array_values(array_filter($columns, function ($column) {
            return Schema::hasColumn('footers', $column);
        }));

        if ($existingColumns) {
            Schema::table('footers', function (Blueprint $table) use ($existingColumns) {
                $table->dropColumn($existingColumns);
            });
        }
    }
}
