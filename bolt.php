<?php

namespace Deployer;

require_once 'recipe/symfony4.php';

add('recipes', ['bolt']);


set('application', 'deployer');
set('deploy_path', '~/{{application}}');
set('writable_mode', 'chmod');
set('writable_chmod_mode', '0777');

add('shared_files', ['.env']);
add('shared_dirs', ['public/files', 'public/theme']);
add('writable_dirs', ['public/files', 'public/theme', 'var/data']);
set('allow_anonymous_stats', false);
set('git_tty', false);
set('ssh_multiplexing', false);

set('bin/console', function () {
    return parse('{{bin/php}} {{release_path}}/bin/console --no-interaction');
});

desc('Clear cache');
task('deploy:website:cache:clear', function () {
    run('{{bin/console}} cache:clear --no-warmup');
});

desc('Warm up cache');
task('deploy:website:cache:warmup', function () {
    run('{{bin/console}} cache:warmup');
});

task('build', function () {
    cd('{{release_path}}');
    run('npm run build');
});

after('deploy:failed', 'deploy:unlock');


