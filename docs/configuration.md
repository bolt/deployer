Configuration
=============

Depending on how you've installed Deployer, running a deploy is done through
either:

- `dep deploy`, if you've installed Deployer globally
- `vendor/bin/dep deploy`, if it's installed as a Composer dependency
- `php deployer.phar deploy`, if you've manually downloaded deployer.phar

In the following parts of this documentation we'll use `dep deploy` in the
examples, but you can substitute these for your usecase.

Initial configuration
---------------------

This tool comes with three files where you can configure its workings:

- `hosts.yaml` - YAML configuration of the target hosts to deploy to
- `deploy.php` - The configuration of the recipe, using Deployer
- `bolt.php` - The Bolt specific Deployer recipe configuration

The first and foremost thing to configure is the `hosts.yaml` file.

```yaml
# The Base section sets the defaults for all stages. Common values:
# - repository: URL of the repo, using `https://`, or `git@` protocol,
# - branch: default branch to deploy

.base: &base
    repository: https://github.com/bolt/project.git
    branch: master

# For each stage, use a unique key (used as "Host"), and list:
#  <<: *base: Sets all values from `.base` as defaults. Override if needed
#  - hostname: IP-address or hostname to SSH into
#  - user: SSH username. Ideally set up as passwordless login
#  - port: SSH port number. Specify, if the server doesn't have SSH on the default port 22
#  - deploy_path: Base path to deploy in
#  - stage: name of the stage. Used in `dep deploy [stagename]`

test:
    <<: *base
    hostname: knutsel.tech
    user: pi
    deploy_path: /home/pi/www/knutsel.tech/deployer
    vhost_symlink: ../public

acc:
    <<: *base
    stage: acc
    hostname: web01.example.org
    port: 8899
    user: username
    deploy_path: /var/www/acc.example.org

prod:
    <<: *base
    stage: prod
    hostname: web02.example.org
    user: username
    deploy_path: /var/www/example.org
```

By default, this file is structured with multiple target environments in mind,
with a `.base` node for the overarching settings for all deployment stages.
It's set up for a generic [DTAP environment][dtap]:

- Development: Your (and other developer's) local working environment
- Test: Where the client can poke at things
- Acceptance: For final acceptance before going live
- Production: For the live, production version of the site.

Obviously, you're free to re-structure this entirely to your needs and
preferences.

To verify the configuration of the configured hosts, run `dep config:hosts`.

![hosts](https://user-images.githubusercontent.com/1833361/117145670-adb4f180-adb3-11eb-9111-62d747b8bb4b.png)

`deploy_path` and `vhost_symlink` determine where Deployer will put its files, and it allows you to keep an always up-to-date symlink to the latest deployment. This is handy for two different scenarios:

- If you can configure the location of the vhost in your webserver's
  configuration, simply set it to `…/deployer/current`, whit points to the
  latest succesful release. You can then set `vhost_symlink: ~`, to prevent
  additional symlinks to be set up.
- If you can not configure the location, `vhost_symlink` allows for the reverse:
  set it up so that it replaces the location of where the vhost points to. For
  example, shared hosting often has a fixed `public_html` folder. You can have
  Deployer deploy to a folder that's next to it, and have `public_html` point to
  the current deployment.

Next, review the contents of `deploy.php`. This is the actual configuration of
the Deployer Recipe. It extends the `bolt.php` recipe, which comes with this
tool. It, in turn, extends Deployer's [`symfony4.php`][sf4] recipe.

In most cases, you'll only need to make modifications in your `deploy.php`. If
you need to make other settings, you can always add them here. Deployer is a
tool that comes with a lot of options. To get a feeling of what's possible, we
recommend reading the [Deployer Website][deployer], but also the built-in
[recipes][recipe] and [deploy tasks][tasks].

Authentication
--------------

As mentioned before, it's probably easiest to set up the target environments so
that Deployer can log on passwordless. You can do this by [setting up
SSH-keys][ssh-keys]. Deployer allows for other authentication methods as well.
You can have it use your existing `~/.ssh/config` set up, or even by pointing
it at your actual private key.

Check the [Hosts page][hosts] at the Deployer site for all options.

[dtap]: https://www.phparch.com/2009/07/professional-programming-dtap-%e2%80%93-part-1-what-is-dtap/
[ssh-keys]: https://linuxize.com/post/how-to-setup-passwordless-ssh-login/
[hosts]: https://deployer.org/docs/hosts.html
[recipe]: https://github.com/deployphp/deployer/tree/master/recipe
[tasks]: https://github.com/deployphp/deployer/tree/master/recipe/deploy
[deployer]: https://deployer.org/docs/hosts.html
[sf4]: https://github.com/deployphp/deployer/blob/master/recipe/symfony.php