<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status',['TO_DO','IN_PROGRESS','DONE'])->default('TO_DO');;
            $table->string('image')->nullable();
            $table->date('due_date')->nullable();
            $table->date('complete_date')->nullable();

            $table->timestamps();

            $table->softDeletes();

        });

        Artisan::call('db:seed', [
            '--class' => SampleTasksSeeder::class
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
