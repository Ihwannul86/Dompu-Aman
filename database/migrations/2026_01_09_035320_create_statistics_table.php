<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('metric_type'); // report_count, user_count, article_view, etc
            $table->string('metric_category')->nullable();
            $table->integer('value')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['date', 'metric_type']);
            $table->unique(['date', 'metric_type', 'metric_category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
