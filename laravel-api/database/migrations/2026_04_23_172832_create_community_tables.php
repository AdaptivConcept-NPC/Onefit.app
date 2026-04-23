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
        // Community Groups
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_ref_code', 50)->unique();
            $table->string('group_name', 50);
            $table->text('group_description');
            $table->string('group_category', 20);
            $table->string('group_privacy', 10);
            $table->string('created_by', 20)->index();
            $table->dateTime('creation_date');
            $table->timestamps();
        });

        // Group Membership (Generic/Legacy)
        Schema::create('group_members', function (Blueprint $table) {
            $table->id();
            $table->string('group_ref_code', 50)->index();
            $table->string('username', 20)->index();
            $table->string('group_role', 20);
            $table->dateTime('group_join_date');
            $table->boolean('active');
            $table->tinyText('status')->nullable();
            $table->timestamps();
        });

        // Reconstructed Community Group Members
        Schema::create('community_group_members', function (Blueprint $table) {
            $table->id();
            $table->string('groups_group_ref_code', 50)->index();
            $table->string('users_username', 20)->index();
            $table->string('group_role', 20)->default('member');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Community Posts
        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('post_date');
            $table->longText('post_message');
            $table->string('username', 20)->index();
            $table->dateTime('modified_date')->nullable();
            $table->string('favourite_ref', 50)->index();
            $table->timestamps();
        });

        // Community Resources
        Schema::create('community_resources', function (Blueprint $table) {
            $table->id();
            $table->string('resource_title', 50);
            $table->text('resource_description')->nullable();
            $table->string('resource_type', 50);
            $table->text('resource_link');
            $table->string('shared_by', 20)->index();
            $table->dateTime('share_date');
            $table->timestamps();
        });

        // Favorite/Save references
        Schema::create('fave_saves', function (Blueprint $table) {
            $table->id();
            $table->string('username', 20)->index();
            $table->string('fave_ref', 50)->index();
            $table->dateTime('fave_date');
            $table->timestamps();
        });

        // News
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('article_title', 255);
            $table->longText('content');
            $table->dateTime('creation_date');
            $table->string('created_by', 20)->index();
            $table->timestamps();
        });

        // Interests
        Schema::create('interests', function (Blueprint $table) {
            $table->id();
            $table->string('interest_title', 50);
            $table->text('interest_description');
            $table->string('created_by', 20)->index();
            $table->dateTime('creation_date');
            $table->timestamps();
        });

        // Fitblog (Legacy Content)
        Schema::create('fitblog_posts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('post_date');
            $table->longText('post_content');
            $table->string('username', 20)->index();
            $table->boolean('verified')->default(false);
            $table->dateTime('modified_date')->nullable();
            $table->string('fave_ref', 50)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fitblog_post_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id')->index();
            $table->text('comment');
            $table->dateTime('comment_date');
            $table->string('username', 20)->index();
            $table->timestamps();
        });

        Schema::create('fitblog_comment_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('post_comment_id')->index();
            $table->text('comment');
            $table->dateTime('comment_date');
            $table->string('username', 20)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitblog_comment_comments');
        Schema::dropIfExists('fitblog_post_comments');
        Schema::dropIfExists('fitblog_posts');
        Schema::dropIfExists('interests');
        Schema::dropIfExists('news');
        Schema::dropIfExists('fave_saves');
        Schema::dropIfExists('community_resources');
        Schema::dropIfExists('community_posts');
        Schema::dropIfExists('community_group_members');
        Schema::dropIfExists('group_members');
        Schema::dropIfExists('groups');
    }
};
