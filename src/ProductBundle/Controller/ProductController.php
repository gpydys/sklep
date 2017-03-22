<?php

namespace ProductBundle\Controller;

use ProductBundle\Entity\Product;
use ProductBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/list", name="product_list")
     * @Method("GET")
     * @Template("ProductBundle:Product:list.html.twig")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('ProductBundle:Product')->getAllSortDesc();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            10
        );

        return [
            'pagination' => $pagination
        ];
    }

    /**
     * @Route("/admin/new-product", name="product_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')"))
     * @Template("ProductBundle:Product:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                $this->get('common.mailer')->sendEmail($product);

                return $this->redirectToRoute('product_list');
            }
        }

        $errors = $form->getErrors(true);

        return [
            'form' => $form->createView(),
            'errors' => $errors
        ];
    }
}
