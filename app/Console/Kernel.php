<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use File;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CmdUserPass::class,
        Commands\CmdUserCreate::class,
        Commands\CreateBackupFolder::class,
        Commands\RemoveBackupFolder::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Para ejecutar la creacion de imagenes por cada minuto
        $path = storage_path()."/logs/imagenes_crear_log.txt";
        if (!File::exists($path)) {
            File::put($path,"");
        }
        $schedule->command('imagenes:crear')
        ->everyMinute()
        ->appendOutputTo($path);





        $schedule->command('backup:clean')->daily()->at('3:00');

        $schedule->command('carpetabackup:crear')->daily()->at('3:55');
        $schedule->command('backup:run')->daily()->at('04:00');
        $schedule->command('carpetabackup:remover')->daily()->at('4:30');


        // Para limpiar los archivos basura cada fin de semana
        $schedule->command('clear:temp')->weekly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
