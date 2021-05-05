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
│   ├── bolt:init-env [after:bolt:symlink:public]
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