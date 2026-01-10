<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('external_url')->nullable()->after('slug');
            $table->string('source_name')->nullable()->after('external_url');
            $table->enum('article_type', ['internal', 'external'])->default('internal')->after('source_name');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['external_url', 'source_name', 'article_type']);
        });
    }
};
