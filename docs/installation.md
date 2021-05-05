Installation
============

This Deployer recipe can be used in a number of ways, whichever you prefer. It
can be used as a stand-alone 'project', so that you can deploy a website,
without having to have a full local copy of the website itself. You can also
install it as a dependency of your own project, so that the configuration to
deploy the site is stored with the project itself.

Regardless of which option you prefer, you'll need to have _both_ the recipe,
as well as Deployer itself.

## Get the recipe

The easiest way to create a stand-alone version is to run the following:

```bash
composer create-project bolt/deployer
```

Alternatively, click the ["Use this template"][use]-button on the
`bolt/project` repository to instantiate your own repository as a copy of the
original.

Lastly, to add it to an existing project, you can run
`composer require --dev bolt/deployer` to install it as a dependency of your
project.

## Install Deployer

If you're using the `composer create`'d version or if you've installed the
recipe as a dependency, you can run `composer install` to install Deployer as a
dependency. You can then run it using `vendor/bin/dep`.

You can also install Deployer as a global composer binary. To do so, run

```bash
curl -LO https://deployer.org/deployer.phar
mv deployer.phar /usr/local/bin/dep
chmod +x /usr/local/bin/dep
```

After doing this, you should be able to run `dep` from anywhere on your local
environment.

If neither of these two work for you, you can get Deployer by [downloading the
Phar file manually][manually], or by running just:

```bash
curl -LO https://deployer.org/deployer.phar
```

Now you can run `php deployer.phar` to run Deployer.

[use]: https://github.com/bolt/project/generate
[manually]: https://deployer.org/download/