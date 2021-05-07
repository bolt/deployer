Regular usage
=============

After the setup and initialisation of the target environment(s) is done, you're ready to actually start deploying. To do so, run:

```bash
dep deploy
```

If all went well, you'll see something like this:

```bash
dep deploy
✈︎ Deploying main on acc.example.org
✔ Executing task deploy:prepare
✔ Executing task deploy:lock
✔ Executing task deploy:release
✔ Executing task deploy:update_code
✔ Executing task deploy:shared
✔ Executing task deploy:vendors
✔ Executing task deploy:writable
✔ Executing task deploy:cache:clear
✔ Executing task deploy:cache:warmup
✔ Executing task deploy:symlink
✔ Executing task bolt:symlink:public
✔ Executing task deploy:unlock
✔ Executing task cleanup
Successfully deployed!
```

You can run it for every configured stage, by passing the name of the stage:

```bash
dep deploy prod
```

You can also specify which branch you wish to deploy, by passing the `--branch`
option:

```bash
dep deploy acc --branch=feature/lets-break-something-tonight
```

If the deploy seemingly went well, but you're not seeing the latest version,
check [Restarting the webserver](troubleshooting.html#restarting-the-webserver)
in the Troubleshooting section.

