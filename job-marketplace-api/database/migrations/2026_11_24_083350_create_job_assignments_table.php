
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marketplace_job_id')
                ->constrained('marketplace_jobs')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('worker_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->enum('status', [
                'pending',
                'accepted',
                'rejected',
                'expired',
                'cancelled',
                'in_progress',
                'completed',
            ])->default('pending');

            $table->enum('request_type', [
                'direct',
                'auto',
            ]);

            $table->timestamp('requested_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->text('rejection_reason')->nullable();
            $table->text('cancellation_reason')->nullable();

            $table->timestamps();

            $table->unique(
                ['marketplace_job_id', 'worker_id'],
                'job_assignment_job_worker_unique'
            );

            $table->index(['worker_id', 'status']);
            $table->index(['marketplace_job_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_assignments');
    }
};
