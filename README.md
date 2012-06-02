# KoalaContentBundle
KoalaContentBundle is a simple CMS built for the Symfony 2 framework using the amazing [Mercury Editor][1] as front end editor.

## Install using composer (Symfony 2.1)
Add koala/content-bundle to composer.json. Currently there is only the dev-master version.

    "require": {
        ...
        "koala/content-bundle": "dev-master"        
    }

Then run `composer update` to install KoalaContentBundle and all its requirements. Composer will automatically register the new namespaces.

## Install using vendors script (Symfony 2.0)
If you're not using composer you can install using the `bin/vendors` script. Add the following to your deps file:

    [KoalaContentBundle]
        git=http://github.com/flojon/KoalaContentBundle.git
        target=/bundles/Koala/ContentBundle
    
    [KnpMenu]
        git=http://github.com/KnpLabs/KnpMenu

    [KnpMenuBundle]
        git=http://github.com/KnpLabs/KnpMenuBundle
        target=/bundles/Knp/Bundle/MenuBundle

    [StofDoctrineExtensionsBundle]
        git=http://github.com/stof/StofDoctrineExtensionsBundle
        target=/bundles/Stof/DoctrineExtensionsBundle

    [DoctrineExtensions]
        git=http://github.com/l3pp4rd/DoctrineExtensions
        target=/gedmo-doctrine-extensions
    
And then run `bin/vendors install`

After installation you need to register the new namespaces in your `app/autoload.php`

    $loader->registerNamespaces(array(
        ...
        'Stof'             => __DIR__.'/../vendor/bundles',
        'Gedmo'            => __DIR__.'/../vendor/gedmo-doctrine-extensions/lib',
        'Knp\Bundle'       => __DIR__.'/../vendor/bundles',
        'Knp\Menu'         => __DIR__.'/../vendor/KnpMenu/src',
        'Koala'            => __DIR__.'/../vendor/bundles',
    ));

## Configuration
Register the new bundles in your `app/AppKernel.php` file:

    public function registerBundles()
    {
        $bundles = array(
            ...
			new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
	        new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Koala\ContentBundle\KoalaContentBundle(),
        );
    
        return $bundles;
    }
    
Enable the Doctrine Tree extension in your `app/config.yml` file:

    stof_doctrine_extensions:
        orm:
            default:
                tree: true

Update the database schema:

    php app/console doctrine:schema:update --force
    
Change `--force` to `--dump-sql` if you rather want a SQL file, with all the changes, that you can run manually.

Install assets:

    php app/console assets:install --symlink web

Install Mercury files under `web/mercury`. Currently it's recommended to use the master version which contains some important fixes.
Download from [https://github.com/jejacks0n/mercury/zipball/master](https://github.com/jejacks0n/mercury/zipball/master) and then copy `stylesheets` and `javascripts` from the `distro` directory into `web/mercury`.

Next step is to setup the routing needed for the bundle to work. Add this to your `app/routing.yml`

    koala_content:
        resource: @KoalaContentBundle/Resources/config/routing.yml
        prefix: /

If you rather want to content pages under a separate section you can change the prefix to something like `/cms`

The last step is to load some default content using the setup command:

    php app/console koala_content:setup

Now fire up your browser and start editing!

## External requirements
* [gedmo-doctrine-extensions](https://github.com/l3pp4rd/DoctrineExtensions)
* [Stof/DoctrineExtensionsBundle](https://github.com/stof/StofDoctrineExtensionsBundle)
* [KnpMenu](https://github.com/KnpLabs/KnpMenu)
* [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle)
* [Mercury Editor][1]

[1]: http://jejacks0n.github.com/mercury/ "Mercury Editor"