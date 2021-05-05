<?php

namespace Deployer;

require_once 'recipe/symfony4.php';

// Config
add('recipes', ['bolt']);
add('shared_files', ['.env']);
add('shared_dirs', ['public/files', 'var/data']);
add('writable_dirs', ['public/files', 'public/thumbs', 'var/', 'config/']);
set('allow_anonymous_stats', false);
set('git_tty', false);
set('ssh_multiplexing', false);

set('bin/console', function () {
    return parse('{{bin/php}} {{release_path}}/bin/console --no-interaction');
});

// Tasks
task('bolt:symlink:public', function () {
    run('rm -f {{deploy_path}}/public && ln -s {{release_path}}/public/ {{deploy_path}}/public');
});

desc('Initialise .env');
task('bolt:init-env', function () {
    run('if [ ! -s {{deploy_path}}/shared/.env ]; then cat {{release_path}}/.env.dist > {{deploy_path}}/shared/.env; fi');
});

after('deploy:failed', 'deploy:unlock');
after('deploy:symlink', 'bolt:symlink:public');
// after('bolt:symlink:public', 'bolt:init-env');

desc('Initialise project');
task('initialise', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'bolt:symlink:public',
    'bolt:init-env',
]);
