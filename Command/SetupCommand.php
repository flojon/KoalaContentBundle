<?php
namespace Koala\ContentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Koala\ContentBundle\Entity\Page;
use Koala\ContentBundle\Entity\Region;

class SetupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('koala_content:setup')
            ->setDescription('Setup default content for KoalaContentBundle')
        ;
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getEntityManager();
        $repository = $em->getRepository('KoalaContentBundle:Page');
        
        /* Add a default Main Menu and a Welcome page */
        $menu = new Page();
        $menu->setMenuTitle('Main Menu');
        $menu->setSlug('main_menu');
        $menu->setLayout('');
        $repository->persistAsFirstChild($menu);
        
        $page = new Page();
        $page->setMenuTitle('Welcome');
        $page->setSlug('welcome');
        $page->setUrl('/');
        $page->setLayout('default');
        $repository->persistAsFirstChildOf($page, $menu);
        
        $region = new Region();
        $region->setPage($page);
        $region->setName('content');
        $region->setContent(<<<EOT
<h1>Hello World</h1>
<p>This is KoalaContentBundle - the simple CMS based on <a href="http://jejacks0n.github.com/mercury/">Mercury Editor</a>. Just click this content to be able to edit it.</p>
<p>See <a href="https://github.com/flojon/KoalaContentBundle">KoalaContentBundle</a> for more information.</p>
EOT
        );
        $em->persist($region);
        
        $em->flush();
    }
}
