<?php

use Illuminate\Database\Seeder;
use App\Staff;

class TableStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    const COUNT_BRANCH = 5; // Стартовое количество сотрудников и колмчество веток
    const MIN_COUNT_SUBJECT=8; //Минимальное количество генерируемых подчененных в отделе
    const MAX_COUNT_SUBJECT=12; //Максимальное количество генерируемых подчиненных в отделе

    protected $progress;

    public function run()
    {
        echo "Please wait for staff generation in ".TableStaffSeeder::COUNT_BRANCH." trees.\n";
        factory(Staff::class, TableStaffSeeder::COUNT_BRANCH)->create([
            'position' => 'Hard CEO'
        ])
            ->each(function ($s){
                $this->create_tree($s,TableStaffSeeder::COUNT_BRANCH-1);
                echo "\n№".($s->id)." tree generated. In the tree generated ".$this->progress." workers\n";
                $this->progress=0;
            });
    }

    public function create_tree($s,$i)
    {
        if (($i)>0) {
            $i--;
            factory(Staff::class, rand(TableStaffSeeder::MIN_COUNT_SUBJECT, TableStaffSeeder::MAX_COUNT_SUBJECT))->create([
                'up_num' => $s->id,
            ])->each(function ($se) use ($i){
                $this->create_tree($se,$i);
            });
        }
        if ($this->progress%(TableStaffSeeder::COUNT_BRANCH*TableStaffSeeder::MAX_COUNT_SUBJECT*TableStaffSeeder::MIN_COUNT_SUBJECT)==0) echo ".";
        $this->progress++;
    }
}
