<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateCRUD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
protected $signature = 'crud:generate {name} {--f|form} {--vw|view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create crud basic';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        
        $name = $this->argument('name');
        $this->controller($name);
        $this->info('create controller success!');
        $this->model($name);
        $this->info('create model success!');

        if($this->option('form')){
            $this->livewireForm($name);
            $this->info('create livewire form success!');
        }

        if($this->option('view')){
            $folder = $this->str_to_kebab_case($name);
            mkdir(resource_path("views/pages/$folder"));
            $this->view($name, $folder);
            $this->info('create views folder & file success!');
        }

        $modelPlural = lcfirst($name);

        $file = fopen(base_path('routes/web.php'), 'a');

        fwrite($file, PHP_EOL."
    Route::post('/{$modelPlural}', [{$name}Controller::class, 'index'])->name('$modelPlural.post');
    Route::delete('/{$modelPlural}/delete/{{$modelPlural}}', [{$name}Controller::class, 'destroy']);
        ".PHP_EOL);

        fclose($file);

        $this->info('generate all success!!');

    }

    protected function getStub($type){
        return file_get_contents(resource_path("/stubs/$type.stub"));
    }

    protected function controller($name){
        $controllerName = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}'
            ],
            [
                $name,
                lcfirst($name)
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerName);

    }

    protected function model($name){
        $modelName = str_replace(['{{modelName}}'], $name, $this->getStub('Model'));
        file_put_contents(app_path("/Models/{$name}.php"), $modelName);
    }

    protected function livewireForm($name){
        $formName = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}'
            ],
            [
                $name,
                lcfirst($name)
            ],
            $this->getStub('LivewireForm')
        );
        file_put_contents(app_path("/Livewire/Forms/{$name}Form.php"), $formName);
    }

    protected function view($name, $folder){
        $modelName = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}'
            ],
            [
                $name,
                lcfirst($name)
            ],
            $this->getStub('View.index')
        );
        file_put_contents(resource_path("/views/pages/$folder/index.blade.php"), $modelName);

        $modelName = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}'
            ],
            [
                $name,
                lcfirst($name)
            ],
            $this->getStub('View.form')
        );
        file_put_contents(resource_path("/views/pages/$folder/form.blade.php"), $modelName);

        $modelName = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}'
            ],
            [
                $name,
                lcfirst($name)
            ],
            $this->getStub('View.update')
        );
        file_put_contents(resource_path("/views/pages/$folder/[$name].blade.php"), $modelName);
    }

    protected function str_to_kebab_case($str) {
        $str = strtolower(preg_replace('/([a-zA-Z])(?=[^a-zA-Z])/', '$1_', $str));
        
        $str = str_replace('_', '-', $str);
        
        $str = ltrim($str, '-');
        $str = rtrim($str, '-');
        
        return $str;
    }

}
