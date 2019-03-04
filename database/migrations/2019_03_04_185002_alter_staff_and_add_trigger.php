<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStaffAndAddTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('boss_name')->nullable(true);
        });

        \DB::unprepared('
            CREATE TRIGGER `staff_on_insert_add_boss_name` BEFORE INSERT ON `staff`
             FOR EACH ROW 
                BEGIN
                    SET NEW.boss_name = (SELECT staff.full_name FROM staff WHERE id = NEW.up_num);
                END
        ');
        \DB::unprepared('
            CREATE TRIGGER `staff_on_update_add_boss_name` BEFORE UPDATE ON `staff`
             FOR EACH ROW 
                BEGIN
                    SET NEW.boss_name = (SELECT staff.full_name FROM staff WHERE id = NEW.up_num);
                END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     //  Schema::table('users', function (Blueprint $table) {
     //      $table->dropColumn('boss_name');
     //  });
        \DB::unprepared('DROP TRIGGER `staff_on_insert_add_boss_name`');
        \DB::unprepared('DROP TRIGGER `staff_on_update_add_boss_name`');
    }
}
