<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Añadir course_id como clave foránea
            $table->unsignedBigInteger('course_id')->nullable()->after('user_id');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('set null');

            // Eliminar columna grade
            $table->dropColumn('grade');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Revertir: eliminar la foreign key y la columna
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');

            // Volver a agregar la columna grade
            $table->string('grade')->nullable();
        });
    }
};
