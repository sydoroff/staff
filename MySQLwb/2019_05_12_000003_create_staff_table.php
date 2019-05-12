<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'staff';

    /**
     * Run the migrations.
     * @table staff
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('full_name', 191);
            $table->string('position', 191)->nullable()->default(null);
            $table->date('employment');
            $table->decimal('pay', 8, 2)->nullable()->default(null);
            $table->integer('up_num')->default('0');
            $table->string('boss_name', 191)->nullable()->default(null);

            $table->index(["up_num"], 'staff_up_num_index');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
