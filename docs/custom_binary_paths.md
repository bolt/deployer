Custom binary paths
===================

Deployer makes a best-guess effort to determine which PHP, Git anc Composer
binaries it should use. On some servers this doesn't work correctly, or you
might want to override it.

For example, when the server runs multiple instances of PHP, you might get the
incorrect on on the command line, if you do `php -v`. To check which binaries
the Bolt Deployer uses, run:

```bash
dep version-info test -vvv
```

You'll get output, something like this:

```bash
➤ Executing task version-info
[test] > command -v 'php' || which 'php' || type -p 'php'
[test] < /usr/bin/php
[test] > /usr/bin/php -v
[test] < PHP 7.3.27-9+ubuntu20.04.1+deb.sury.org+1 (cli) (built: Feb 23 2021 15:10:30) ( NTS )
[test] < Copyright (c) 1997-2018 The PHP Group
[test] < Zend Engine v3.3.27, Copyright (c) 1998-2018 Zend Technologies
[test] <     with Zend OPcache v7.3.27-9+ubuntu20.04.1+deb.sury.org+1, Copyright (c) 1999-2018, by Zend Technologies
[test] > command -v 'git' || which 'git' || type -p 'git'
[test] < /usr/bin/git
[test] > /usr/bin/git --version
[test] < git version 2.25.1
[test] > if hash composer 2>/dev/null; then echo 'true'; fi
[test] < true
[test] > command -v 'composer' || which 'composer' || type -p 'composer'
[test] < /usr/local/bin/composer
[test] > /usr/local/bin/composer --version
[test] < Composer version 2.1.2 2021-06-07 16:03:06
• done on [test]
✔ Ok [4s 627ms]
```

If one of these isn't correct, you can set these under `bin:` in your `hosts.yaml`. For example:

```yaml
acc:
    <<: *base
    stage: acc
    hostname: accept.example.org
    user: myusername
    deploy_path: /home/example/deployer
    vhost_symlink: ../public_html
    bin:
        php: /usr/local/bin/ea-php73
        composer: /usr/local/bin/ea-php73 -d memory_limit=2G /opt/cpanel/composer/bin/composer
        git: /home/username/bin/git
```

Note: If the default PHP isn't the correct one, you'll probably _also_ need to
specify the Composer binary, because otherwise, it will still be 'invoked' using
the incorrect version of PHP.
