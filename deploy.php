<?php
namespace Deployer;

require 'recipe/laravel.php';

after('deploy:failed', 'deploy:unlock');

set('application', 'mylaravelapp');
set('repository', 'https://github.com/rahmat-riyadi/quickly-mini-erp-be.git');
set('php_fpm_version', '8.2');

host('prod')
    ->set('remote_user', 'deployer')
    ->set('hostname', '103.149.177.215')
    ->set('deploy_path', '/home/deployer');

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'deploy:publish',
    // 'php-fpm:reload',
]);

// task('npm:run:prod', function () {
    // cd('{{release_or_current_path}}');
    // run('npm run prod');
// });

after('deploy:failed', 'deploy:unlock');