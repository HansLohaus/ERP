<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
class CreateBackupFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carpetabackup:crear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la carpeta de backup con las imagenes a respaldar, para poder realizar el respaldo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $folder = File::makeDirectory(storage_path().'/backup');

      $full_dir = scandir(public_path('uploads'));
      asort($full_dir);

      $paths = array();


      $n = 1180;

      $included_folders = array_slice($full_dir, $n);


     foreach($included_folders as $f) {

        File::copyDirectory(public_path('uploads/'.$f), storage_path().'/backup/'.$f);
      }
    }
}
