<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/php-fpm.php';
require 'contrib/npm.php';

set('application', 'mylaravelapp');
set('repository', 'https://github.com/rahmat-riyadi/quickly-mini-erp-be.git');
set('php_fpm_version', '8.2');

host('prod')
    ->set('remote_user', 'root')
    ->set('hostname', '103.149.177.215')
    ->set('deploy_path', '/home/aplikasi');

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'npm:install',
    'npm:run:prod',
    'deploy:publish',
    'php-fpm:reload',
]);

// task('npm:run:prod', function () {
//     cd('{{release_or_current_path}}');
//     run('npm run prod');
// });

after('deploy:failed', 'deploy:unlock');