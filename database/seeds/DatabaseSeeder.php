<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        create_primary_user();
        initialize_roles();
        create_sample_users();
        create_Example_tasks();
        create_usuari_sergi();


        // Crear usuaris de prova


        // TODO -> Com fer-ho en el registre


    }
}
