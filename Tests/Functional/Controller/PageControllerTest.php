<?php
namespace Koala\ContentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('h1:contains("Hello World")')->count());
    }

    public function testNotFound()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/this-page-does-not-exist');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());        
    }

    public function testNew()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/new');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('legend:contains("Menu options")')->count());
        $this->assertGreaterThan(0, $crawler->filter('legend:contains("Page options")')->count());

        $form = $crawler->selectButton('Create Page')->form();

        // set some values
        $form['menuItem[parent]']->select('1');
        $form['menuItem[label]'] = 'New Menu Item';
        $form['menuItem[content][title]'] = 'New Page Title';
        $form['menuItem[content][routes][0][pattern]'] = '/new-page-url';
        $form['menuItem[content][layout]']->select('default');

        // submit the form
        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/new-page-url'));
        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('title:contains("New Page Title")')->count());
        $this->assertGreaterThan(0, $crawler->filter('nav:contains("New Menu Item")')->count());

        return $crawler->filter('meta[name=mercury-edit]')->attr('content');
    }

    /**
     * @depends testNew
     */
    public function testEditAndDelete($edit_url)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $edit_url);
    
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('legend:contains("Menu options")')->count());
        $this->assertGreaterThan(0, $crawler->filter('legend:contains("Page options")')->count());

        $form = $crawler->selectButton('Save Page')->form();

        $this->assertEquals(1, $form['menuItem[parent]']->getValue());
        $this->assertEquals('New Menu Item', $form['menuItem[label]']->getValue());
        $this->assertEquals('New Page Title', $form['menuItem[content][title]']->getValue());
        $this->assertEquals('/new-page-url', $form['menuItem[content][routes][0][pattern]']->getValue());
        $this->assertEquals('default', $form['menuItem[content][layout]']->getValue());

        // set some values
        $form['menuItem[parent]']->select('2');
        $form['menuItem[label]'] = 'New Sub Menu Item';
        $form['menuItem[content][title]'] = 'New Sub Page Title';
        $form['menuItem[content][routes][0][pattern]'] = '/page/new-sub-page-url';
        $form['menuItem[content][layout]']->select('default');

        // submit the form
        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/page/new-sub-page-url'));
        $crawler = $client->followRedirect();
        
        $this->assertEquals(0, $crawler->filter('nav:contains("New Menu Item")')->count());
        $this->assertGreaterThan(0, $crawler->filter('nav:contains("New Sub Menu Item")')->count());

        // Delete
        $crawler = $client->request('GET', $edit_url);
        $delete_url = $crawler->selectButton('Remove page')->attr('data-action');
        $client->request('POST', $delete_url);
        $this->assertTrue($client->getResponse()->isRedirect('/'));
        $crawler = $client->followRedirect();
        $this->assertEquals(0, $crawler->filter('nav:contains("New Sub Menu Item")')->count());        
    }
}