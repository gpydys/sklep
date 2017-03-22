<?php

namespace CommonBundle\Command;

use ProductBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateProducts extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('products:generate')
            ->setDescription('Zasila bazę testowymi produktami')
            ->addArgument(
                'count',
                InputArgument::REQUIRED,
                'Liczba produktów do wygenerowania'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $count = $input->getArgument('count');

        $em = $this->getContainer()->get('doctrine')->getManager();

        for ($i = 1; $i <= $count; $i++) {
            $product = new Product();
            $product->setName('Testowy produkt ' . $i);
            $product->setDescription('Testowy opis produktu ' . $i . ' Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis.');
            $product->setPrice((rand(1, 500) / $i));
            $product->setCreatedAt();

            $em->persist($product);

            if ($i % 200 == 0) {
                $em->flush();
                $em->clear();
            }
        }
        $em->flush();

        $output->writeln('Zapisano do bazy ' . ($i - 1) . ' produktów');
    }
}
