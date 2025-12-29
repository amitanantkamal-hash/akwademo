<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('source')->nullable();
            $table->enum('stage', ['New', 'In Progress', 'Follow-up', 'Won', 'Lost', 'Closed'])->default('New');
            $table->timestamp('next_followup_at')->nullable();
            $table->boolean('notifications')->default(true);
            $table->timestamps();
            
            $table->unique(['company_id', 'contact_id']); // One lead per contact per company
        });

        // Lead notes table
        Schema::create('lead_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->text('note');
            $table->timestamps();
        });

        // Lead follow-ups table
        Schema::create('lead_followups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->timestamp('scheduled_at');
            $table->text('notes')->nullable();
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_followups');
        Schema::dropIfExists('lead_notes');
        Schema::dropIfExists('leads');
    }
}
