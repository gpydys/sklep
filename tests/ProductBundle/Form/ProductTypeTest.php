<?php

namespace ProductBundle\Tests\Form;

use ProductBundle\Form\ProductType;
use ProductBundle\Model\Product;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductTypeTest extends TypeTestCase
{
    private $validator;

    protected function getExtensions()
    {
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->validator
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList()));
        $this->validator
            ->method('getMetadataFor')
            ->will($this->returnValue(new ClassMetadata('Symfony\Component\Form\Form')));

        return array(
            new ValidatorExtension($this->validator)
        );
    }

    public function testSubmitFromValid()
    {
        $formData = [
            'name' => 'Testowa nazwa produktu',
            'description' => 'Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Test test test.',
            'price' => 12.99
        ];

        $form = $this->factory->create(ProductType::class);

        $product = Product::fromArray($formData);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($product, $form->getData());
    }
}