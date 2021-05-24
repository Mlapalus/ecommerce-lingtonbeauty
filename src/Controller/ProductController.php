<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\SearchType;
use App\Model\Search;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/shop", name="shop")
     */
    public function index(Request $request): Response
    {

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $products = $this->em
                            ->getRepository(Product::class)
                                ->findBySearch($search);
        } else {
            $products = $this->em->getRepository(Product::class)->findAll();
        }

        return $this->render('product/index.html.twig',
            [
                'products' => $products,
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function show(Product $product): Response
    {
        $selectedProduct = $this->em->getRepository(Product::class)
                                    ->find($product->getId());

        if (!$selectedProduct)
        {
            return $this->redirectToRoute('shop');
        }
        return $this->render(
            'product/show.html.twig',
            [
                'product' => $selectedProduct
            ]
        );
    }
}
