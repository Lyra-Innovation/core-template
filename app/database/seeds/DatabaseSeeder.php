<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{

    protected $toTruncate = ['users', 'competences', 'sectors', 'allies', 'resources', 'sector_competences'];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach($this->toTruncate as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();

        factory(App\User::class, 1)->create(['name' => 'admin', 'password' => 'admin', 'role' => 0, 'game_status' => -1]);
        factory(App\User::class, 1)->create(['name' => 'dynamizer', 'password' => 'dynamizer', 'role' => 1, 'user_responsable_id' => 1, 'game_status' => -1]);
        factory(App\User::class, 1)->create(['name' => 'user', 'password' => 'user', 'role' => 2, 'user_responsable_id' => 2]);

        //static
        $competences = factory(App\Competence::class, 10)->create(['max_level' => 8]);
        $sectors = factory(App\Sector::class, 3)->create();
        factory(App\Allie::class, 5)->create();
        factory(App\Resource::class, 5)->create();

        for($i = 0; $i < count($competences); $i++){
            $comp = $i % count($sectors);
           
            factory(App\SectorCompetence::class)->create(['sector_id' => $sectors[$comp], 
                'competence_id' => $competences[$i]]);

            $compi = ($i + 1) % count($sectors);
            factory(App\SectorCompetence::class)->create(['sector_id' => $sectors[$compi], 
                'competence_id' => $competences[$i]]);
        }

        factory(App\Question::class, 1)->create();
        factory(App\Answer::class, 1)->create(['question_id' => 1, 'correct' => 0]);
        factory(App\Answer::class, 1)->create(['question_id' => 1, 'correct' => 1]);
    }
}
