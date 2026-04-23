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
        // Exercises
        Schema::create('exercises', function (Blueprint $table) {
            $table->id('exercise_id');
            $table->string('exercise_name', 100);
            $table->text('exercise_description')->nullable();
            $table->string('exercise_type', 50)->nullable();
            $table->string('exercise_category', 50)->nullable();
            $table->string('exercise_difficulty', 20)->nullable();
            $table->string('muscle_group', 50)->nullable();
            $table->integer('xp_points')->default(0);
            $table->string('created_by', 20)->index();
            $table->timestamps();
        });

        // Training Programs
        Schema::create('training_programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_ref_code', 50)->unique();
            $table->string('program_title', 100);
            $table->text('program_description')->nullable();
            $table->string('program_duration', 50)->nullable();
            $table->string('program_category', 50);
            $table->string('program_privacy', 20)->default('public');
            $table->string('created_by', 20)->index();
            $table->integer('xp_points')->default(0);
            $table->boolean('active')->default(true);
            $table->dateTime('creation_date');
            $table->timestamps();
        });

        // Program Subscriptions
        Schema::create('program_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('username', 20)->index();
            $table->string('program_ref_code', 50)->index();
            $table->dateTime('subscribe_date');
            $table->timestamps();
        });

        // Activity Tracker Stats - BMI & Weight
        Schema::create('user_profile_fitness_stats_bmi', function (Blueprint $table) {
            $table->id('fitness_stats_bmi_id');
            $table->string('workout_activity', 50)->nullable();
            $table->string('datasource', 50)->nullable();
            $table->float('bmi');
            $table->string('bmi_status', 50);
            $table->float('weight');
            $table->date('date');
            $table->time('time');
            $table->integer('user_profiles_user_profile_id')->index('bmi_profile_idx');
            $table->integer('exercises_exercise_id')->nullable()->index('bmi_exercise_idx');
            $table->timestamps();
        });

        // Activity Tracker Stats - Heart Rate
        Schema::create('user_profile_fitness_stats_heart_rate', function (Blueprint $table) {
            $table->id('fitness_stats_hr_id');
            $table->string('workout_activity', 50)->nullable();
            $table->string('datasource', 50)->nullable();
            $table->integer('bpm');
            $table->date('date');
            $table->time('time');
            $table->integer('user_profiles_user_profile_id')->index('hr_profile_idx');
            $table->integer('exercises_exercise_id')->nullable()->index('hr_exercise_idx');
            $table->timestamps();
        });

        // Activity Tracker Stats - Body Temp
        Schema::create('user_profile_fitness_stats_body_temp', function (Blueprint $table) {
            $table->id('fitness_stats_temp_id');
            $table->string('workout_activity', 50)->nullable();
            $table->string('datasource', 50)->nullable();
            $table->float('temperature');
            $table->date('date');
            $table->time('time');
            $table->integer('user_profiles_user_profile_id')->index('temp_profile_idx');
            $table->integer('exercises_exercise_id')->nullable()->index('temp_exercise_idx');
            $table->timestamps();
        });

        // Activity Tracker Stats - Speed
        Schema::create('user_profile_fitness_stats_speed', function (Blueprint $table) {
            $table->id('fitness_stats_speed_id');
            $table->string('workout_activity', 50)->nullable();
            $table->string('datasource', 50)->nullable();
            $table->float('speed');
            $table->date('date');
            $table->time('time');
            $table->integer('user_profiles_user_profile_id')->index('speed_profile_idx');
            $table->integer('exercises_exercise_id')->nullable()->index('speed_exercise_idx');
            $table->timestamps();
        });

        // Activity Tracker Stats - Step Count
        Schema::create('user_profile_fitness_stats_step_count', function (Blueprint $table) {
            $table->id('fitness_stats_steps_id');
            $table->string('workout_activity', 50)->nullable();
            $table->string('datasource', 50)->nullable();
            $table->integer('steps');
            $table->date('date');
            $table->time('time');
            $table->integer('user_profiles_user_profile_id')->index('steps_profile_idx');
            $table->integer('exercises_exercise_id')->nullable()->index('steps_exercise_idx');
            $table->timestamps();
        });

        // Activity Log
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('log_type', 50);
            $table->text('log_message');
            $table->text('log_details')->nullable();
            $table->string('log_category', 50)->nullable();
            $table->string('log_ref', 50)->nullable();
            $table->string('users_username', 20)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_log');
        Schema::dropIfExists('user_profile_fitness_stats_step_count');
        Schema::dropIfExists('user_profile_fitness_stats_speed');
        Schema::dropIfExists('user_profile_fitness_stats_body_temp');
        Schema::dropIfExists('user_profile_fitness_stats_heart_rate');
        Schema::dropIfExists('user_profile_fitness_stats_bmi');
        Schema::dropIfExists('program_subscribers');
        Schema::dropIfExists('training_programs');
        Schema::dropIfExists('exercises');
    }
};
