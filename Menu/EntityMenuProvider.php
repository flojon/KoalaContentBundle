<?php

namespace Koala\ContentBundle\Menu;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Menu\Provider\MenuProviderInterface;
use Knp\Menu\FactoryInterface;

class EntityMenuProvider implements MenuProviderInterface
{
    protected $container;

    protected $factory;
    
    protected $em;
    
    protected $className;
    
    public function __construct(ContainerInterface $container, FactoryInterface $factory, ObjectManager $em, $className = null)    
    {
        $this->container = $container;
        $this->factory = $factory;
        $this->em = $em;
        $this->className = $className;
    }

    /**
     * Retrieves a menu by its name
     *
     * @param string $name
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     * @throws \InvalidArgumentException if the menu does not exists
     */
    function get($name, array $options = array())
    {
        $node = $this->em->getRepository($this->className)->findOneByLabel($name);
        if (!$node)
            throw new \InvalidArgumentException(sprintf('The menu "%s" is not defined.', $name));
        
        $menu = $this->factory->createFromNode($node); 
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        return $menu;
    }

    /**
     * Checks whether a menu exists in this provider
     *
     * @param string $name
     * @param array $options
     * @return bool
     */
    function has($name, array $options = array())
    {
        $node = $this->em->getRepository($this->className)->findOneByLabel($name);

        return !!$node;
    }
}
