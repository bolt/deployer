Requirements
============

In order for this Deployer recipe to work, there are some requirements for both
the environment that you run it on, as well as for the environment(s) that you
want to deploy to.

Additionally, there's a few things you might want to sort out beforehand,
because it'll make using this tool much more smoothly.

Local requirements
------------------

Your local setup should run PHP 7.3 or higher, and you should have command line access.

- PHP 7.3 or higher
- CLI access
- `git` and `composer` should be installed
- Recommended: Set up passwordless / keybased SSH into the deployment
  environments.

Remote requirements
-------------------

- SSH access (preferably key-based / passwordless)
- PHP 7.2.9 or higher
- `git`
- `composer`
- Recommended: Set up tokens for the deployment environment to be able to access
  the Git repository.
