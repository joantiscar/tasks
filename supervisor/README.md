#Supervisor para worker
Aqui es on ficare els fitxers del supervisor

Path: 
````
/etc/supervisor/conf.d/tasks.joantiscar.scool.cat.conf
````
Contingut: 

LOCAL:
````
[program:laravel-worker-tasks-joantiscar-scool-cat]
process_name=%(program_name)s_%(process_num)02d
command=php /home/dios/Code/joantiscar/tasks/artisan queue:work redis --sleep=3 --tries=3
autostart=true
autorestart=true
user=dios
numprocs=8
redirect_stderr=true
stdout_logfile=/home/dios/Code/joantiscar/tasks/storage/logs/worker.log
````
EXPLOTACIO:
````
[program:laravel-worker-tasks-joantiscar-scool-cat]
process_name=%(program_name)s_%(process_num)02d
command=php /home/forge/tasks.joantiscar.scool.cat/artisan queue:work redis --sleep=3 --tries=3
autostart=true
autorestart=true
user=forge
numprocs=8
redirect_stderr=true
stdout_logfile=/home/forge/tasks.joantiscar.scool.cat/storage/logs/worker.log
````


#Supervisor para Horizon

Local: 
````
[program:horizon-tasks-joantiscar-scool-cat]
process_name=%(program_name)s
command=php /home/dios/Code/joantiscar/tasks/artisan horizon
autostart=true
autorestart=true
user=dios
redirect_stderr=true
stdout_logfile=/home/dios/Code/joantiscar/tasks/storage/logs/horizon.log
````

EXPLOTACIO:
````
[program:horizon-tasks-joantiscar-scool-cat]
process_name=%(program_name)s_%(process_num)02d
command=php /home/forge/tasks.joantiscar.scool.cat/artisan horizon
autostart=true
autorestart=true
user=forge
redirect_stderr=true
stdout_logfile=/home/forge/tasks.joantiscar.scool.cat/storage/logs/horizon.log
````
