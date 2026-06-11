<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // 既存のセクション文字列から sections レコードを生成
        $names = DB::table('words')->select('section')->distinct()->pluck('section');
        foreach ($names as $name) {
            DB::table('sections')->insert(['name' => $name, 'created_at' => now(), 'updated_at' => now()]);
        }

        // words に section_id を追加
        Schema::table('words', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id')->nullable()->after('japanese');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('restrict');
        });

        // section 文字列から section_id を紐付け
        $sections = DB::table('sections')->get();
        foreach ($sections as $section) {
            DB::table('words')->where('section', $section->name)->update(['section_id' => $section->id]);
        }

        // section 文字列カラムを削除
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn('section');
        });
    }

    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->string('section')->default('default')->after('japanese');
        });

        $sections = DB::table('sections')->get();
        foreach ($sections as $section) {
            DB::table('words')->where('section_id', $section->id)->update(['section' => $section->name]);
        }

        Schema::table('words', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->dropColumn('section_id');
        });

        Schema::dropIfExists('sections');
    }
};
