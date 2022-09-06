Tips
====

## See the hierarchy of tasks

Run `dep debug:task deploy` to see the hierarchy of tasks that are configured:

```text
The task-tree for deploy:
├── deploy
│   ├── deploy:info
│   ├── deploy:prepare
│   ├── deploy:lock
│   ├── deploy:release
│   ├── deploy:update_code
│   ├── deploy:shared
│   ├── deploy:vendors
│   ├── deploy:writable
│   ├── deploy:cache:clear
│   ├── deploy:cache:warmup
│   ├── deploy:symlink
│   ├── bolt:symlink:public [after:deploy:symlink]
│   ├── bolt:wrap-up [after:deploy:symlink]
│   ├── deploy:unlock
│   └── cleanup
├── success [after:deploy]
└── reload:php-fpm [after:deploy]
```

## Checking the hosts

To verify the configuration of the configured hosts, run `dep config:hosts`

![hosts](https://user-images.githubusercontent.com/1833361/117145670-adb4f180-adb3-11eb-9111-62d747b8bb4b.png)

## Quick SSH access

To log in to the target environment, use `dep ssh` to get a list of the available hosts.

![ssh](https://user-images.githubusercontent.com/1833361/117148769-d68ab600-adb6-11eb-9a11-69cdf3c70ff3.png)

Alternatively, run `dep ssh name`, to directly log into that environment.


## Running a shell script before deploy

Depending on the configuration of your webhost or specific project needs, you
might want to run a shell script on the target machine before an attempted
deployment.

To do so, simply create a shell script in the main deployer folder, where
`releases` and `shared` reside. Name it `warm-up.sh`, and make sure it's
executable. If that script is present, the recipe will automatically run it.

For a trivial example, see:

```bash
#!/usr/bin/env bash

PHP=`which php`

echo "All warmed up, and ready to go!"

cd current
$PHP bin/console app:do-the-right-thing
```


## Running a shell script after deploy

Depending on the configuration of your webhost or specific project needs, you
might want to run a shell script on the target machine after a successful
deployment.

To do so, simply create a shell script in the main deployer folder, where
`releases` and `shared` reside. Name it `wrap-up.sh`, and make sure it's
executable. If that script is present, the recipe will automatically run it.

For a trivial example, see:

```bash
#!/usr/bin/env bash

PHP=`which php`

echo "Wrapping up!"

cd current
$PHP bin/console app:do-the-right-thing
```
