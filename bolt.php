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
set('vhost_symlink', null);

set('bin/console', function () {
    return parse('{{release_path}}/bin/console --no-interaction');
});

set('bin/php', function () {
    $bin = get('bin', []);
    return isset($bin['php']) ? $bin['php'] : locateBinaryPath('php');
});

set('bin/git', function () {
    $bin = get('bin', []);
    return isset($bin['git']) ? $bin['git'] : locateBinaryPath('git');
});

set('bin/composer', function () {
    $bin = get('bin', []);
    if (isset($bin['composer'])) {
        return $bin['composer'];
    }

    if (commandExist('composer')) {
        $composer = locateBinaryPath('composer');
    }

    if (empty($composer)) {
        run("cd {{release_path}} && curl -sS https://getcomposer.org/installer | {{bin/php}}");
        $composer = '{{bin/php}} {{release_path}}/composer.phar';
    }

    return $composer;
});

set('branch', function () {
    return input()->getOption('branch') ?: get('default_branch');
});

// Tasks
task('bolt:symlink:public', function () {
    if (get('vhost_symlink')) {
        run('rm -rf {{deploy_path}}/{{vhost_symlink}} && ln -s {{release_path}}/public/ {{deploy_path}}/{{vhost_symlink}}');
    }
});

desc('Initialise .env');
task('bolt:init-env', function () {
    run('if [ ! -s {{deploy_path}}/shared/.env ]; then cat {{release_path}}/.env.dist > {{deploy_path}}/shared/.env; fi');
});

desc('Run the "wrap up"-script');
task('bolt:wrap-up', function () {
    run('if [ -x {{deploy_path}}/wrap-up.sh ]; then cd {{deploy_path}}; ./wrap-up.sh; fi');
});

desc('Run the "warm up"-script');
task('bolt:warm-up', function () {
    run('if [ -x {{deploy_path}}/warm-up.sh ]; then cd {{deploy_path}}; ./warm-up.sh; fi');
});

after('deploy:failed', 'deploy:unlock');
after('deploy:symlink', 'bolt:symlink:public');
after('deploy:symlink', 'bolt:wrap-up');
after('deploy:prepare', 'bolt:warm-up');
// after('bolt:symlink:public', 'bolt:init-env');

desc('Initialise project');
task('initialise', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:writable',
    'deploy:shared',
    'bolt:symlink:public',
    'bolt:init-env',
]);

task('version-info', function () {
    run('{{bin/php}} -v');
    run('{{bin/git}} --version');
    run('{{bin/composer}} --version');
});