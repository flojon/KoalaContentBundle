<?php
namespace Koala\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Koala\ContentBundle\Entity\Region;
use Koala\ContentBundle\MercuryRegions;

class MercuryController extends Controller
{
    /**
     * Receive uploaded images from Mercury and return url as JSON
     *
     * @Route("/mercury/images")
     * @Method("POST")
     */
    public function imagesAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) { // Ajax Call?
            throw new \Exception('This URL should only be called using AJAX');
        }

        // param name is "image[image]"
        $uploadedFile = $request->files->get("image");
        $uploadedFile = $uploadedFile['image'];
        $path = $this->get('kernel')->getRootDir() . "/../web/uploads/"; // TODO use config for upload dir
        $name = $this->getUniqueFilename($path, $uploadedFile->getClientOriginalName());
        $file = $uploadedFile->move($path, $name);

        // Return {"image": {"url": "__url__"}}
        $image['image']['url'] = $request->getBasePath() . "/uploads/" . $name; // TODO use config for upload dir
        $response = new Response(json_encode($image));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Save contents from Mercury Editor
     * @Route("/mercury/content/{url}", defaults={"url"="/"}, requirements={"url"=".*"})
     * @Method("POST")
     */
    public function contentAction(Request $request, $url = "/")
    {
        if (!$request->isXmlHttpRequest()) { // Ajax Call?
            throw new \Exception('This URL should only be called using AJAX');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $page = $em->getRepository('KoalaContentBundle:Page')->findOneByUrl($url);
        if (!$page) {
            throw $this->createNotFoundException('Invalid URL');
        }

        $content = $request->get('content');
        if (!empty($content))
        {
            $regions = new MercuryRegions($content);

            foreach ($page->getRegions() as $region)
            {
                $name = $region->getName();
                if (empty($regions[$name])) {
                    $em->remove($region);
                }
                else {
                    $region->setContent($regions[$name]);
                }
                unset($regions[$name]);
            }
            foreach ($regions as $name=>$content)
            {
                $region = new Region();
                $region->setName($name);
                $region->setContent($content);
                $em->persist($region);
                $page->addRegion($region);
            }

            $em->flush();
        }

        $response = new Response("");
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Will create unique filename in directory by appending a number to basename
     *
     * @param string $dir directory to look in
     * @param string $filename basename to use for unique filename
     * @return string unique filename in supplied directory
     * @author Jonas Flodén
     **/
    private function getUniqueFilename($dir, $filename)
    {
        if (!file_exists($this->join_paths($dir, $filename))) {
            return $filename;
        }

        list($name, $ext) = explode(".", $filename, 2);
        $ext = ".".$ext;
        $i=1;
        while (file_exists($this->join_paths($dir, $name . $i . $ext))) {
            $i++;
        }

        return $name . $i . $ext;
    }

    /**
     * Join two paths together
     *
     * @param string $dir1
     * @param string $dir2
     * @return string
     * @author Jonas Flodén
     */
    private function join_paths($dir1, $dir2)
    {
        return rtrim($dir1, DIRECTORY_SEPARATOR) . "/" . ltrim($dir2, DIRECTORY_SEPARATOR);
    }
}