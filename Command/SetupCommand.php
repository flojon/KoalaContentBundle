<?php
namespace Koala\ContentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Koala\ContentBundle\Entity\Page;
use Koala\ContentBundle\Entity\Route;
use Koala\ContentBundle\Entity\MenuItem;
use Koala\ContentBundle\Entity\Region;

class SetupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('koala_content:setup')
            ->setDescription('Setup default content for KoalaContentBundle')
            ->addOption('reset', null, InputOption::VALUE_NONE, 'Reset current contents in database (using doctrine:schema:drop)')
        ;
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getEntityManager();

        if ($input->getOption('reset')) {
            $output->writeln("<info>Resetting schema using 'doctrine:schema:drop'</info>");
            $command = $this->getApplication()->find('doctrine:schema:drop');

            $arguments = array(
                'command' => 'doctrine:schema:drop',
                '--force'  => true,
            );

            $input = new ArrayInput($arguments);
            $returnCode = $command->run($input, $output);
        }
        
        /* Validate schema */
        $output->writeln("<info>Validating schema using 'doctrine:schema:validate'</info>");
        $command = $this->getApplication()->find('doctrine:schema:validate');

        $arguments = array(
            'command' => 'doctrine:schema:validate',
        );

        $input = new ArrayInput($arguments);
        $returnCode = $command->run($input, $output);

        if ($returnCode >= 2) {
            /* Update the database */
            $output->writeln("<info>Updating schema using 'doctrine:schema:update'</info>");
            $command = $this->getApplication()->find('doctrine:schema:update');

            $arguments = array(
                'command' => 'doctrine:schema:update',
                '--force'  => true,
            );

            $input = new ArrayInput($arguments);
            $returnCode = $command->run($input, $output);    
        }

        /* Check for contents */
        if ($em->getRepository('KoalaContentBundle:MenuItem')->findAll()
                || $em->getRepository('KoalaContentBundle:Page')->findAll()
                || $em->getRepository('KoalaContentBundle:Route')->findAll()
                || $em->getRepository('KoalaContentBundle:Region')->findAll()) {
            $output->writeln("<error>Your database already has content, use '--reset' to reset it</error>");
            return;
        }

        /* Add a default Main Menu and a Welcome page */
        $repository = $em->getRepository('KoalaContentBundle:MenuItem');
        
        $output->writeln("<info>Adding default content</info>");
        $route = new Route();
        $route->setPattern('/');
        $em->persist($route);

        $page = new Page();
        $page->setTitle('Welcome');
        $page->setLayout('default');
        $page->addRoute($route);
        $em->persist($page);

        $menu = new MenuItem();
        $menu->setLabel('main_menu');
        $repository->persistAsFirstChild($menu);

        $menuItem = new MenuItem();
        $menuItem->setLabel('Welcome');
        $menuItem->setPage($page);
        $menu->addMenuItem($menuItem);
        $repository->persistAsFirstChildOf($menuItem, $menu);

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
