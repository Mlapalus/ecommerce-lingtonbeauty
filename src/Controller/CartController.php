<?php

namespace App\Controller;

use App\Model\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{

    private Cart $cart;
    private EntityManagerInterface $em;

    public function __construct(Cart $cart, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->cart = $cart;
    }

    /**
     * @Route("/panier", name="cart")
     */
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'cartComplete' => $this->cart->getAll()
        ]);
    }

    /**
     * @Route("/panier/add/{slug}", name="add-to-cart")
     */
    public function add(string $slug): Response
    {
        $product = $this->em->getRepository(Product::class)->findOneBy(['slug' => $slug]);
        if ($product)
        {
            $this->cart->add($product);
        }
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/panier/effacer", name="remove-cart")
     */
    public function remove(): Response
    {
        $this->cart->remove();
        return $this->redirectToRoute('shop');
    }

    /**
     * @Route("/panier/supprimer/{slug}", name="remove-cart-item")
     */
    public function deleteItem(Product $product): Response
    {
        $this->cart->deleteItem($product);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/panier/moins/{slug}", name="minus-cart-item")
     */
    public function minusItem(Product $product): Response
    {
        $this->cart->minus($product);
        return $this->redirectToRoute('cart');
    }
}
