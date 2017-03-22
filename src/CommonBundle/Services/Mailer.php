<?php

namespace CommonBundle\Services;

use ProductBundle\Entity\Product;
use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

class Mailer
{
    protected $twig;
    protected $mailer;

    public function __construct(Twig_Environment $twig, Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function sendEmail(Product $product)
    {
        $body = $this->renderTemplate($product);

        $message = Swift_Message::newInstance()
            ->setSubject('Produkt ' . $product->getName() . ' utworzony')
            ->setFrom('noreply@example.com')
            ->setTo('fake@example.com')
            ->setBody($body)
        ;
        $this->mailer->send($message);
    }

    public function renderTemplate(Product $product)
    {
        return $this->twig->render(
            'CommonBundle:Email:createProduct.txt.twig',
            [
                'product' => $product
            ]
        );
    }
}