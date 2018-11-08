<?php


use App\Task;
use App\User;
use Illuminate\Support\Facades\DB;

if (!function_exists('create_example_tasks')){
    function create_Example_tasks(){
        $task = Task::create([
            'name' => 'Comprar pa',
            'completed' => false
        ]);
        $task = Task::create([
            'name' => 'Comprar llet',
            'completed' => false
        ]);
        $task = task::create([
            'name' => 'Estudiar PHP',
            'completed' => true
        ]);
    }
}
if (!function_exists('create_primary_user')){
    function create_primary_user(){
        $user = User::where('email', 'joantiscar@iesebre.com')->first();
        if (!$user){
        User::create([
            'name' => 'Joan Tíscar Verdiell',
            'email' => 'joantiscar@iesebre.com',
            'password' => bcrypt(env('PRIMARY_USER_PASSWORD', '123456'))
        ]);
        }
    }
}
if (!function_exists('create_mysql_database')){
    function create_mysql_database($name){

        //PDO
        // MYSQL: CREATE DATABASE IF NOT EXISTS $name
        $statement = "CREATE DATABASE IF NOT EXISTS $name";
        DB::connection('mysqlroot')->getPdo()->exec($statement);
    }
    if (!function_exists('drop_mysql_database')){
        function create_mysql_database($name){

            //PDO
            // MYSQL: CREATE DATABASE IF NOT EXISTS $name
            $statement = "DROP DATABASE IF NOT EXISTS $name";
            DB::connection('mysqlroot')->getPdo()->exec($statement);
        }
}