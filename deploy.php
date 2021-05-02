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

after('deploy:failed', 'deploy:unlock');
after('deploy:symlink', 'bolt:symlink:public');
after('bolt:symlink:public', 'bolt:init-env');
