<?php


use App\Tag;
use App\Task;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (!function_exists('create_example_tasks')){
    function create_Example_tasks(){
        $task = Task::create([
            'name' => 'Comprar pa',
            'completed' => false,
            'user_id' => 1
        ]);
        $task = Task::create([
            'name' => 'Comprar llet',
            'completed' => false,
            'user_id' => 1
        ]);
        $task = task::create([
            'name' => 'Estudiar PHP',
            'completed' => true,
            'user_id' => 1
        ]);
    }
}
if (!function_exists('create_example_tags')) {
    function create_example_tags() {
        Tag::create([
            'name' => 'Compras',
            'description' => 'Aqui van las compras',
            'color' => '#04B404'
        ]);
        Tag::create([
            'name' => 'Estudios',
            'description' => 'Aqui van los estudios',
            'color' => '#04B404'
        ]);
        Tag::create([
            'name' => 'Trabajo',
            'description' => 'Aqui van los trabajos',
            'color' => '#04B404'
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
        $user->admin = true;
        }
    }
}
if (!function_exists('create_mysql_database')) {
    function create_mysql_database($name)
    {

        //PDO
        // MYSQL: CREATE DATABASE IF NOT EXISTS $name
        $statement = "CREATE DATABASE IF NOT EXISTS $name";
        DB::connection('mysqlroot')->getPdo()->exec($statement);
    }

    if (!function_exists('drop_mysql_database')) {
        function drop_mysql_database($name)
        {

            //PDO
            // MYSQL: CREATE DATABASE IF NOT EXISTS $name
            $statement = "DROP DATABASE IF NOT EXISTS $name";
            DB::connection('mysqlroot')->getPdo()->exec($statement);
        }
    }
    if (!function_exists('create_mysql_user')) {
        function create_mysql_user($name, $password = null, $host = 'localhost')
        {

            //PDO
            // MYSQL: CREATE DATABASE IF NOT EXISTS $name
            if(!$password) $password = str_random();

            $statement = "CREATE USER IF NOT EXISTS {$name}@{$host}";
            DB::connection('mysqlroot')->getPdo()->exec($statement);
            $statement = "ALTER USER '{$name}'@'{$host}' IDENTIFIED BY '{$password}'";
            DB::connection('mysqlroot')->getPdo()->exec($statement);
        }
    }
    if (!function_exists('grant_mysql_privileges')) {
        function grant_mysql_privileges($user, $database, $host = 'localhost'){
            $statement = "GRANT ALL PRIVILEGES ON {$database}.* TO '{$user}'@'{$host}' WITH GRANT OPTION";
            DB::connection('mysqlroot')->getPdo()->exec($statement);
        }
    }
    if (!function_exists('create_database')) {
        function create_database(){
            create_mysql_database(env('DB_DATABASE'));
            create_mysql_user(env('DB_USERNAME'), env('DB_PASSWORD'));
            grant_mysql_privileges(env('DB_USERNAME'), env('DB_DATABASE'));
        }
    }
    if (!function_exists('initialize_roles()')) {
        function initialize_roles()
        {
            try {
                // Crear rols
                $taskmanager = Role::create([
                    'name' => 'TaskManager'
                ]);
            } catch (Exception $e) {
            }
            try {
                $tasks = Role::create([
                    'name' => 'Tasks'
                ]);
            } catch (Exception $e) {
            }
            // Crear permisos
            try {
                // CRUD de tasques
                Permission::create([
                    'name' => 'tasks.index'
                ]);
                Permission::create([
                    'name' => 'tasks.create'
                ]);
                Permission::create([
                    'name' => 'tasks.store'
                ]);
                Permission::create([
                    'name' => 'tasks.show'
                ]);
                Permission::create([
                    'name' => 'tasks.update'
                ]);
                Permission::create([
                    'name' => 'tasks.complete'
                ]);
                Permission::create([
                    'name' => 'tasks.uncomplete'
                ]);
                Permission::create([
                    'name' => 'tasks.destroy'
                ]);
            } catch (Exception $e) {
            }
            // Assignar permisos a taskmanager
            try {
                $taskmanager = Role::findByName('TaskManager');
                $taskmanager->givePermissionTo('tasks.index');
                $taskmanager->givePermissionTo('tasks.create');
                $taskmanager->givePermissionTo('tasks.store');
                $taskmanager->givePermissionTo('tasks.show');
                $taskmanager->givePermissionTo('tasks.update');
                $taskmanager->givePermissionTo('tasks.complete');
                $taskmanager->givePermissionTo('tasks.uncomplete');
                $taskmanager->givePermissionTo('tasks.destroy');
            } catch (Exception $e) {
            }
            try{
            // CRUD tasques d'un usuari concret
            Permission::create([
                'name' => 'user.tasks.index'
            ]);
            Permission::create([
                'name' => 'user.tasks.create'
            ]);
            Permission::create([
                'name' => 'user.tasks.store'
            ]);
            Permission::create([
                'name' => 'user.tasks.show'
            ]);
            Permission::create([
                'name' => 'user.tasks.update'
            ]);
            Permission::create([
                'name' => 'user.tasks.complete'
            ]);
            Permission::create([
                'name' => 'user.tasks.uncomplete'
            ]);
            Permission::create([
                'name' => 'user.tasks.destroy'
            ]);
        }catch(Exception $e){}


            try{
            $tasks = Role::findByName('Tasks');
                $tasks->givePermissionTo('user.tasks.index');
                $tasks->givePermissionTo('user.tasks.create');
                $tasks->givePermissionTo('user.tasks.store');
                $tasks->givePermissionTo('user.tasks.show');
                $tasks->givePermissionTo('user.tasks.update');
                $tasks->givePermissionTo('user.tasks.complete');
                $tasks->givePermissionTo('user.tasks.uncomplete');
                $tasks->givePermissionTo('user.tasks.destroy');


//
//            Gate::define('user.tasks.update', function($user){
//                return $user->hasPermission('user.tasks.update');
//            });
            }catch(Exception $e){}
        }
    }
    if (!function_exists('create_sample_users')) {
        function create_sample_users(){

            try {
                // Dona -> No te cap permis ni cap rol
                $dona = factory(User::class)->create([
                    'name' => 'Maria Cinta',
                    'email' => 'mariacinta@yahoo.es',
                    'password' => Hash::make('123456')
                ]);
            }catch(Exception $e){}
            try {
                // Home -> Te mes permisos que Dona
                $home = factory(User::class)->create([
                    'name' => 'Paco',
                    'email' => 'pacopacopacodemipaco@gmail.com',
                    'password' => Hash::make('123456')
                ]);
                $home->assignRole('Tasks');
            }catch(Exception $e){}
            try {
                // Deu -> Té mes permisos que home
                $deu = factory(User::class)->create([
                    'name' => 'Joan Tíscar',
                    'email' => 'joantiscar@gmail.com',
                    'password' => Hash::make('123456')
                ]);
                $deu->assignRole('TaskManager');
            }catch(Exception $e){}
        }
    }
    if (!function_exists('create_usuari_sergi')) {
        function create_usuari_sergi(){
            try {
                // Deu -> Té mes permisos que home
                $deu = factory(User::class)->create([
                    'name' => 'sergi',
                    'email' => 'sergiturbadenas@gmail.com',
                    'password' => Hash::make('secret')
                ]);
                $deu->assignRole('Tasks');
                $deu->assignRole('TaskManager');
                $deu->admin = true;
            }catch(Exception $e){}
        }
    }
}

// TODO: Crear multiples usuaris amb diferents rols
// TODO: Com gestionar el superadmin

