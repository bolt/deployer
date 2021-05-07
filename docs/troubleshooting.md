Troubleshooting
===============

## Debugging a step

When something is breaking (chances are this is "when", not "if"), you'll want
to dig in to see what's causing the issue. It's probably redundant to mention
here, but often reading the text in the big red error will tell you what's
causing the breakage.

![borken](https://user-images.githubusercontent.com/1833361/117442709-6a838b80-af37-11eb-983e-123d759320a8.png)

In the screenshot above you'll notice that it breaks on `deploy:update_code`,
as indicated by the `➤`, before Deployer wraps up the failed deploy. You can
investigate by running just that step, and outputting verbose debug
information:

```bash
dep deploy:update_code -vvv
```

This will tell you exactly what's it doing behind the screens, and will
probably shed some light on what's going wrong.

## Restarting the webserver

If you're noticing that after a seemingly succesfull deploy your changes are
not showing up online, it might be that your webserver doesn't recognize that
it needs to look at a different location for the latest deploy.

If this is the case, you'll need to restart the webserver, or just its
`php-fpm` process. Depending on the server, it can be something like either one
of these:

```bash
sudo service php7.3-fpm restart
sudo /etc/init.d/php-fpm restart
sudo service apache restart
sudo service nginx restart
```

If you don't know, consult your server administrator. When you know what works
for your server update the `deploy.php` script to do this automatically for you
on each deploy:

```php
task('reload:php-fpm', function () {
    // run('sudo /etc/init.d/php-fpm restart');
    run('sudo service php7.3-fpm restart');
});

after('deploy', 'reload:php-fpm');
after('rollback', 'reload:php-fpm');
```
