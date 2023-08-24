<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateCRUD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $this->controller($name);
        $this->model($name);

        $modelPlural = lcfirst($name);

        Storage::append(
            base_path('routes/api.php'),
            "Route::group(['prefix' => '$modelPlural'], function(){
                Route::controller({$name}Controller::class)->group(function(){
                    Route::get('/', 'index');
                    Route::post('/', 'store');
                    Route::put('/{$modelPlural}', 'update');
                    Route::delete('/{$modelPlural}', 'destroy');
                });
            });"
        );

        
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
        $modelName = str_replace('{{modelName}}', $name, $this->getStub('Model'));
        file_put_contents(app_path("/Models/{$name}.php"), $modelName);
    }
}
