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

desc('Clear cache');
task('deploy:website:cache:clear', function () {
    run('{{bin/console}} cache:clear --no-warmup');
});

desc('Warm up cache');
task('deploy:website:cache:warmup', function () {
    run('{{bin/console}} cache:warmup');
});

after('deploy:cache:clear', 'deploy:website:cache:clear');
after('deploy:website:cache:clear', 'deploy:website:cache:warmup');
