Initial run
===========

In order to do its work, Deployer creates a new build of the site on the remote
server, keeping the files it needs to, and intalling the rest. If you'd just
run `dep deploy`, you'd bump into a number of issues, if the remote server
isn't yet set up with an initial build of the site.

Run the following command to initialise the `test` environment:

```bash
dep initialise
```

Note: if you're not passing in a stage name with the command, Deployer will
deploy to the `default_stage` stage, which you can set in `deploy.php`.

Now, after logging in using SSH (using your preferred way, or by means of `dep
ssh`), you can see the initial structure created by Deployer for our Bolt
projects.

```text
.
├── .dep/
├── public -> /home/pi/www/knutsel.tech/releases/1/public/
├── release -> releases/1/
├── releases/
│   └── 1/
│       ├── …
│       ├── config/
│       ├── public/
│       │   ├── files -> ../../../shared/public/files/
│       │   ├── theme/
│       │   ├── thumbs/
│       │   ├── .htaccess
│       │   ├── index.php
│       │   └── robots.txt
│       ├── …
│       ├── .env -> ../../shared/.env
│       ├── .env.local -> ../../shared/.env.local
│       ├── .env.local.php -> ../../shared/.env.local.php
│       ├── index.php
│       ├── …
│       └── UPDATE.md
└── shared/
    ├── public/
    │   └── files/
    ├── var/
    │   ├── data/
    │   ├── log/
    │   └── sessions/
    ├── .env
    ├── .env.local
    └── .env.local.php

21 directories, 25 files
```

Inspecting this structure, we'll notice the following interesting parts:

- There's a `release` symlink, that points to the current release, in the
  `releases` folder. After the setup is done, this will be replaced by a
  `current` symlink that always points to the current release.
- There's a `public` symlink. This is the one you will want to point your
  webserver configuration at, because this will always point to the `public/`
  folder in the last succesful deploy.
- `releases/1/` is a checkout of the git repository, that's used for the
  deployment.
- In it, there's the `public/` folder, which contains a number of symlinks to
  various items in the `shared` folder. This will ensure that what's in here
  will not get lost on subsequent deploys.
- The `shared/` folder will contain stubs of files and folders, that will be
  shared across subsequent deploys.

Now, to wrap up the configuration of your site-to-be on the webserver side,
you'll need to do the following things:

- Configure your webserver so that the webroot points to the `public` symlink.
  Note that it should **not** point to where the symlink is pointing, because
  that location is volatile: It will change on every deploy. You can also
  configure this using the `vhost_symlink` parameter in your `hosts.yaml`. See
  the section on the "configuration" page about this topic.
- Place the contents of `files/` in `shared/public/files/`.
- If you're using SQLite, place the database file in `shared/var/data`.
- Apply the environment-specific configuration in `shared/.env`,
  `shared/.env.local` or your `ENV` settings.
- Ensure both the Command-line user and the webserver's user have read/write
  access to the files in `shared/`. How this is done optimally, depends on how
  the server is configured. To just make them writable to all, use:

```bash
chmod -R 777 shared/.env* shared/public/files shared/var/data/ shared/var/log shared/var/sessions
```

Obviously, you'll need to repeat these steps for every environment or 'stage'
that your project will use. Add the stage name to the command, to run it for
that environment. For example:

```bash
dep initialise acc
dep initialise prod
```
