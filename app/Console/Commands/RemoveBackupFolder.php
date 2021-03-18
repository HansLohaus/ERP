<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
class RemoveBackupFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carpetabackup:remover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina la carpeta de backup';

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
        File::deleteDirectory(storage_path().'/backup');
    }
}
