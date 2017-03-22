<?php

namespace ProductBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $client->request('GET', '/list');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testNewWithoutUser()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/new-product');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testNewWithUser()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ]);

        $client->request('GET', '/admin/new-product');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
