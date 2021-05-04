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
task('reload:php-fpm', function () {
    // run('sudo /etc/init.d/php-fpm restart');
    run('sudo service php7.3-fpm restart');
});
after('deploy', 'reload:php-fpm');
after('rollback', 'reload:php-fpm');

