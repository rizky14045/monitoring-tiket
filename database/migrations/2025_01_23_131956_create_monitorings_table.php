<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('incident')->nullable();
            $table->string('incident_rec_id')->nullable();
            $table->string('priority_name')->nullable();
            $table->string('case_owner_rec_id')->nullable();
            $table->string('sla_class')->nullable();
            $table->string('case_owner')->nullable();
            $table->string('case_owner_email')->nullable();
            $table->string('unit_level_1')->nullable();
            $table->string('unit_level_2')->nullable();
            $table->string('unit_level_3')->nullable();
            $table->string('complainant_rec_id')->nullable();
            $table->boolean('complainant')->nullable();
            $table->string('reported_by')->nullable();
            $table->string('reported_by_email')->nullable();
            $table->string('summary')->nullable();
            $table->string('source')->nullable();
            $table->string('call_type')->nullable();
            $table->string('status')->nullable();
            $table->string('description')->nullable();
            $table->string('fcr')->nullable();
            $table->string('service_family')->nullable();
            $table->string('service_group')->nullable();
            $table->string('service_type')->nullable();
            $table->string('cause')->nullable();
            $table->string('cause_code')->nullable();
            $table->string('resolution')->nullable();
            $table->boolean('send_notif_to_secondary_email')->nullable();
            $table->string('area_ops_safe')->nullable();
            $table->string('mail_groups_sti_ops')->nullable();
            $table->timestamp('ticket_created_at')->nullable();
            $table->string('ticket_created_by')->nullable();
            $table->timestamp('task_created_on')->nullable();
            $table->string('task_created_by')->nullable();
            $table->string('task_assign_to')->nullable();
            $table->timestamp('task_assign_on')->nullable();
            $table->string('owner_team')->nullable();
            $table->timestamp('task_completed_on')->nullable();
            $table->timestamp('ticket_resolved_on')->nullable();
            $table->string('ticket_resolved_by')->nullable();
            $table->timestamp('ticket_modified_on')->nullable();
            $table->string('ticket_modified_by')->nullable();
            $table->timestamp('ticket_closed_on')->nullable();
            $table->string('ticket_closed_by')->nullable();
            $table->string('priority')->nullable();
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
        Schema::dropIfExists('monitorings');
    }
}
