<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Teams Weekly Schedules
        Schema::create('teams_weekly_schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->string('group_ref_code', 50)->index();
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->string('created_by', 20)->index();
            $table->timestamps();
        });

        // Team Weekly Activities
        Schema::create('team_weekly_activities', function (Blueprint $table) {
            $table->id('teams_activity_id');
            $table->integer('schedule_id')->index();
            $table->string('activity_title', 100);
            $table->text('activity_description')->nullable();
            $table->date('activity_date');
            $table->time('activity_time')->nullable();
            $table->string('activity_duration', 50)->nullable();
            $table->integer('exercise_id')->nullable()->index();
            $table->integer('reps')->nullable();
            $table->integer('sets')->nullable();
            $table->timestamps();
        });

        // Teams Group Members
        Schema::create('teams_group_members', function (Blueprint $table) {
            $table->id();
            $table->string('groups_group_ref_code', 50)->index();
            $table->string('users_username', 20)->index();
            $table->string('group_role', 20)->default('member');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Premium Group Members
        Schema::create('premium_group_members', function (Blueprint $table) {
            $table->id();
            $table->string('groups_group_ref_code', 50)->index();
            $table->string('users_username', 20)->index();
            $table->string('group_role', 20)->default('member');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('premium_group_members');
        Schema::dropIfExists('teams_group_members');
        Schema::dropIfExists('team_weekly_activities');
        Schema::dropIfExists('teams_weekly_schedules');
    }
};
