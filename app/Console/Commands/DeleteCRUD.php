<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteCRUD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:delete {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete CRUD basic';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $name = $this->argument('name');

        if(File::exists(app_path("/Http/Controllers/{$name}Controller.php"))){
            File::delete(app_path("/Http/Controllers/{$name}Controller.php"));
            $this->info('delete controller success!');
        }

        if(File::exists(app_path("/Models/{$name}.php"))){
            File::delete(app_path("/Models/{$name}.php"));
            $this->info('delete model success!');
        }

        if(File::exists(app_path("/Livewire/Forms/{$name}Form.php"))){
            File::delete(app_path("/Livewire/Forms/{$name}Form.php"));
            $this->info('delete livewire form success!');
        }

        $folder = $name;

        $path = resource_path('/views/pages/'.$folder);

        $this->deleteFolder($path);

        $this->info('delete view folder & file success!');

        $this->info('delete crud basic successfully!!');

    }

    protected function str_to_kebab_case($str) {
        $str = strtolower(preg_replace('/([a-zA-Z])(?=[^a-zA-Z])/', '$1_', $str));
        
        $str = str_replace('_', '-', $str);
        
        $str = ltrim($str, '-');
        $str = rtrim($str, '-');
        
        return $str;
    }

    protected function deleteFolder($path) {
        if (is_dir($path)) {
            $objects = scandir($path);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($path . "/" . $object) == "dir") {
                        deleteFolder($path . "/" . $object);
                    } else {
                        unlink($path . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($path);
        }
    }
}
