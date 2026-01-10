<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('reporter_name')->nullable(); // Untuk laporan anonim
            $table->string('reporter_phone')->nullable();
            $table->string('reporter_email')->nullable();
            $table->boolean('is_anonymous')->default(false);

            $table->string('incident_type')->default('umum'); // Jenis kekerasan
            $table->text('incident_description');
            $table->string('incident_location');
            $table->string('incident_address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->date('incident_date');
            $table->time('incident_time')->nullable();

            $table->json('victim_info')->nullable(); // Info korban
            $table->json('perpetrator_info')->nullable(); // Info pelaku
            $table->json('witness_info')->nullable(); // Info saksi
            $table->json('evidence_files')->nullable(); // File bukti (foto/video)

            $table->enum('status', [
                'pending',
                'reviewing',
                'investigating',
                'resolved',
                'rejected',
                'closed'
            ])->default('pending');

            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('severity', ['minor', 'moderate', 'serious', 'critical'])->default('moderate');

            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at']);
            $table->index(['incident_type', 'incident_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
