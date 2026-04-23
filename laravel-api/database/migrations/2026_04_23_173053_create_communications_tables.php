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
        // Conversations
        Schema::create('user_conversations', function (Blueprint $table) {
            $table->id('conversation_id');
            $table->dateTime('conversation_start_date');
            $table->string('primary_user', 20)->index();
            $table->string('secondary_user', 20)->index();
            $table->string('conversations_reference', 50)->nullable()->index();
            $table->timestamps();
        });

        // Messages
        Schema::create('user_conversation_messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->integer('conversation_id')->index();
            $table->longText('message');
            $table->dateTime('send_date');
            $table->boolean('message_read')->default(false);
            $table->boolean('message_deleted')->default(false);
            $table->string('sender', 20)->index();
            $table->string('receiver', 20)->index();
            $table->timestamps();
        });

        // Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->string('notification_title', 50);
            $table->text('notification_message');
            $table->dateTime('notification_date');
            $table->boolean('notification_read')->default(false);
            $table->string('notify_user', 20)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('user_conversation_messages');
        Schema::dropIfExists('user_conversations');
    }
};
