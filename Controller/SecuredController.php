<?php
namespace Koala\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecuredController extends Controller
{
    protected function can_edit()
    {
        try {
            // Check if user has right to edit
            $editor_role = $this->container->getParameter('koala_content.editor_role');

            return $this->get('security.context')->isGranted($editor_role);
        } catch (\Exception $e) {
            switch (get_class($e)) {
                case 'Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException':
                case 'Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException':
                    // Security is not enabled so everyone can edit
                    return true;
                default:
                    throw $e;
            }
        }
    }
}
