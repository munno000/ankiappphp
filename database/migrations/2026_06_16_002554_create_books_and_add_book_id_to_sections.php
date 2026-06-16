<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // 既存セクションのために既定ブックを作成
        $bookId = DB::table('books')->insertGetId([
            'name' => 'デフォルト',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('sections', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id')->nullable()->after('id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

        DB::table('sections')->update(['book_id' => $bookId]);

        Schema::table('sections', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropColumn('book_id');
        });

        Schema::dropIfExists('books');
    }
};
