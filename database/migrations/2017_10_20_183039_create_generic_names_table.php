<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenericNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generic_names', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 100);
            $table->string('code', 100)->nullable();
            $table->text('description')->nullable();

            $table->string('indications_ids', 255)->nullable();
            $table->string('indications_keywords', 255)->nullable();

            $table->string('therapeutic_class_ids', 255)->nullable();
            $table->string('therapeutic_class_names', 255)->nullable();

            $table->boolean('status')->default(true);

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generic_names');
    }
}
