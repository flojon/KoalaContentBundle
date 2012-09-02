<?php
namespace Koala\ContentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\DomCrawler\Crawler;

class MercuryControllerTest extends WebTestCase
{
    private $page_url = '/test-page';
    private $edit_url;
    private $save_url;

    public function setUp()
    {
        $client = static::createClient();
        
        // Create new page
        $crawler = $client->request('GET', '/new');
        $form = $crawler->selectButton('Create Page')->form();

        // set some values
        $form['menuItem[parent]']->select('1');
        $form['menuItem[label]'] = 'Edit Menu Item';
        $form['menuItem[content][title]'] = 'Edit Page Title';
        $form['menuItem[content][routes][0][pattern]'] = $this->page_url;
        $form['menuItem[content][layout]']->select('default');

        // submit the form
        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        $this->edit_url = $crawler->filter('meta[name=mercury-edit]')->attr('content');
        $this->save_url = $crawler->filter('meta[name=mercury-content]')->attr('content');        
    }

    public function tearDown()
    {
        // Delete page
        $client = static::createClient();
        $crawler = $client->request('GET', $this->edit_url);
        $delete_url = $crawler->selectButton('Remove page')->attr('data-action');
        $client->request('POST', $delete_url);
    }

    public function testContent()
    {
        $client = static::createClient();

        // Send JSON data
        $content = array('content' => array(
           'content' => array(
                'type' => 'full',
                'data' => array(),
                'value' => "<h1>Hello World!!</h1>",
                'snippets' => array(),
           )
        ));
        $client->request('PUT', $this->save_url, array(), array(), array("HTTP_X_REQUESTED_WITH" => "XMLHttpRequest"), json_encode($content));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        // Get page and make sure it's updated
        $crawler = $client->request('GET', $this->page_url);
        $this->assertGreaterThan(0, $crawler->filter('div#content > h1:contains("Hello World!!")')->count());

        // Make an update
        $content['content']['content']['value'] = '<h1>Goodbye World...</h1>';
        $client->request('PUT', $this->save_url, array(), array(), array("HTTP_X_REQUESTED_WITH" => "XMLHttpRequest"), json_encode($content));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        // Get page and make sure it's updated
        $crawler = $client->request('GET', $this->page_url);
        $this->assertGreaterThan(0, $crawler->filter('div#content > h1:contains("Goodbye World...")')->count());
    }

    public function testImages()
    {
        $client = static::createClient();
        $kernel_dir = isset($_SERVER['KERNEL_DIR'])
            ? $_SERVER['KERNEL_DIR'] : static::getPhpUnitXmlDir();
        $webroot = $kernel_dir . "/../web";
        $file = dirname(__FILE__) . '/cat.jpg'; // Test file
        $tmp_file = tempnam('', 'cat'); // Temp copy
        copy($file, $tmp_file);
        $files = array('image' => array('image' => array(
            'name' => 'cat.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => $tmp_file,
            'error' => 0,
            'size' => 29931,
        )));
        // Test file upload
        $client->request('POST', '/mercury/images', array(), $files, array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('content-type'));
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertNotEmpty($response['image']['url']);
        $this->assertFileEquals($file, $webroot . $response['image']['url']);
        unlink($webroot . $response['image']['url']); // Remove uploaded file
    }
}
