<?php

namespace ProductBundle\Form;

use ProductBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa',
                'constraints' => [
                    new Constraints\NotBlank(['message' => 'Należy wpisać nazwę!']),
                    new Constraints\Length(['max' => 255, 'maxMessage' => 'Nazwa nie może być dłuższa niż 255 znaków!'])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Opis',
                'constraints' => [
                    new Constraints\NotBlank(['message' => 'Należy wpisać opis!']),
                    new Constraints\Length(['min' => 100, 'minMessage' => 'Opis musi mieć minimum 100 znaków!'])
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Cena',
                'currency' => false,
                'scale' => 2,
                'constraints' => [
                    new Constraints\NotBlank(['message' => 'Należy wpisać cenę!']),
                ],
                'invalid_message' =>'Cena nie może zawierać innych znaków niż cyfry i "," lub "."!'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
