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
        // General User Profiles
        Schema::create('general_user_profiles', function (Blueprint $table) {
            $table->id('user_profile_id');
            $table->string('users_username', 20)->unique();
            $table->string('about', 45)->nullable();
            $table->string('profile_type', 45)->nullable();
            $table->string('profile_url', 100)->nullable();
            $table->string('verification', 50)->default('unverified');
            $table->longText('profile_banner_url')->nullable();
            $table->longText('profile_image_url')->nullable();
            $table->timestamps();
        });

        // Extended Profile Info
        Schema::create('user_profile_about', function (Blueprint $table) {
            $table->id();
            $table->integer('general_user_profiles_user_profile_id')->index();
            $table->float('height')->nullable();
            $table->float('target_weight')->nullable();
            $table->text('fitness_goals')->nullable();
            $table->string('preferred_workout_time', 20)->nullable();
            $table->timestamps();
        });

        // Social Networks
        Schema::create('user_socials', function (Blueprint $table) {
            $table->id('user_social_id');
            $table->string('social_network', 50);
            $table->string('handle', 50);
            $table->text('link');
            $table->string('username', 20)->index();
            $table->timestamps();
        });

        // Friends
        Schema::create('friends', function (Blueprint $table) {
            $table->id('friend_id');
            $table->string('username', 20)->index();
            $table->string('friend_username', 20)->index();
            $table->dateTime('accept_date');
            $table->dateTime('unfriend_date')->nullable();
            $table->boolean('friendship_status');
            $table->timestamps();
        });

        // Administrators
        Schema::create('administrators', function (Blueprint $table) {
            $table->id();
            $table->string('username', 20)->unique();
            $table->string('admin_role', 50);
            $table->boolean('account_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrators');
        Schema::dropIfExists('friends');
        Schema::dropIfExists('user_socials');
        Schema::dropIfExists('user_profile_about');
        Schema::dropIfExists('general_user_profiles');
    }
};
