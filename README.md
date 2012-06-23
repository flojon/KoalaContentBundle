# KoalaContentBundle
KoalaContentBundle is a simple CMS built for the Symfony 2 framework using the amazing [Mercury Editor][1] as front end editor.

## Install using composer (Symfony 2.1)
Add koala/content-bundle to composer.json.

    "require": {
        ...
        "koala/content-bundle": "dev-master"        
    }

Then run `composer update` to install KoalaContentBundle and all its requirements. Composer will automatically register the new namespaces.

## Configuration
Register the new bundles in your `app/AppKernel.php` file:

    public function registerBundles()
    {
        $bundles = array(
            ...
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Symfony\Cmf\Bundle\RoutingExtraBundle\SymfonyCmfRoutingExtraBundle(),
            new Koala\ContentBundle\KoalaContentBundle(),
        );
    
        return $bundles;
    }
    
Enable the Doctrine Tree extension and the Symfony CMF router in your `app/config/config.yml` file:

    stof_doctrine_extensions:
        orm:
            default:
                tree: true

    symfony_cmf_routing_extra:
        chain:
            routers_by_id:
                koala_content.dynamic_router: 200
                router.default: 100

Install assets:

    php app/console assets:install --symlink web

Install Mercury files under `web/mercury`. It's recommended to use the newest release, currently 0.8. (See See [Mercury Downloads](https://github.com/jejacks0n/mercury/downloads))

Download from [https://github.com/downloads/jejacks0n/mercury/mercury-v0.8.0.zip](https://github.com/downloads/jejacks0n/mercury/mercury-v0.8.0.zip) and extract to `web/mercury`.

Next step is to setup the routing needed for the bundle to work. Add this to your `app/config/routing.yml`

    koala_content:
        resource: @KoalaContentBundle/Resources/config/routing.yml
        prefix: /

_Note: By default Symfony has a _welcome route in `app/config/routing_dev.yml` which you need to remove if you want to use the root._

If you rather want to content pages under a separate section you can change the prefix to something like `/cms`

The last step is to update the database schema and load some default content. Make sure you have setup your database config in `app/config/parameters.yml` before running the setup command:

    php app/console koala_content:setup

Now fire up your browser and start editing!

## External requirements
* [gedmo-doctrine-extensions](https://github.com/l3pp4rd/DoctrineExtensions)
* [Stof/DoctrineExtensionsBundle](https://github.com/stof/StofDoctrineExtensionsBundle)
* [KnpMenu](https://github.com/KnpLabs/KnpMenu)
* [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle)
* [SymfonyCMF Routing](https://github.com/symfony-cmf/Routing)
* [Mercury Editor][1]

[1]: http://jejacks0n.github.com/mercury/ "Mercury Editor"