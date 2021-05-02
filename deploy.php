<?php
namespace Deployer;

require 'bolt.php';

// Config

set('application', 'deployer');
set('deploy_path', '~/{{application}}');
set('writable_mode', 'chmod');
set('writable_chmod_mode', '0777');


// Hosts
inventory('hosts.yaml');

// Tasks

task('build', function () {
    cd('{{release_path}}');
    run('npm run build');
});

after('deploy:failed', 'deploy:unlock');
