<?php
namespace Koala\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

class SecuredController extends Controller
{
    protected function can_edit()
    {
        try {
            // Check if user has right to edit
            $editor_role = $this->container->getParameter('koala_content.editor_role');
            $can_edit = $this->get('security.context')->isGranted($editor_role);
        } catch (AuthenticationCredentialsNotFoundException $e) {
            // Security is not enabled so everyone can edit
            $can_edit = true;
        }
		
		return $can_edit;
    }
}