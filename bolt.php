<?php

namespace Deployer;

require_once 'recipe/symfony4.php';

add('recipes', ['bolt']);


add('shared_files', ['.env']);
add('shared_dirs', ['public/files', 'public/theme']);
add('writable_dirs', ['public/files', 'public/theme', 'var/data']);
set('allow_anonymous_stats', false);
set('git_tty', false);
set('ssh_multiplexing', false);

set('bin/console', function () {
    return parse('{{bin/php}} {{release_path}}/bin/console --no-interaction');
});

// Tasks
task('bolt:symlink:public', function() {
    run('rm {{deploy_path}}/public && ln -s {{release_path}}/public/ {{deploy_path}}/public');
});

task('bolt:init-env', function() {
    run('if [ ! -s {{deploy_path}}/shared/.env ]; then cat {{release_path}}/.env.dist > {{deploy_path}}/shared/.env; fi');
});