<?php

namespace CommonBundle\Test\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MailerTest extends WebTestCase
{
    public function testSendMailAfterCreate()
    {
        $data = [
            'name' => 'Testowa nazwa produktu',
            'description' => 'Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Test test test.',
            'price' => 12.99
        ];

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ]);

        $crawler = $client->request('POST', '/admin/new-product');

        $form = $crawler->filter('form')->form([
            'product[name]' => $data['name'],
            'product[description]' => $data['description'],
            'product[price]' => $data['price']
        ]);

        $client->submit($form);

        $profile = $client->getProfile();
        $collector = $profile->getCollector('swiftmailer');



        $this->assertEquals(1, $collector->getMessageCount());
    }
}