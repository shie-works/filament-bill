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
        Schema::create('user_has_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('model_name', 50)->comment('モデル名');
            $table->boolean('view_any')->comment('一覧表示が可能か');
            $table->boolean('create')->comment('作成が可能か 1=true');
            $table->boolean('update')->comment('更新が可能か 1=true' );
            $table->boolean('delete')->comment('削除が可能か 1=true');
            $table->boolean('view')->comment('詳細表示が可能か  1=true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_has_policies');
    }
};
