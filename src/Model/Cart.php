<?php

namespace App\Model;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

    private SessionInterface $session;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->session = $session;
        $this->em = $em;
    }

    public function add(Product $product)
    {
        $cart = $this->session->get('cart', []);
        $slug = $product->getSlug();
        
        if (!empty($cart[$slug])) {
            $cart[$slug]++;
        } else {
            $cart[$slug] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function minus(Product $product)
    {
        $cart = $this->session->get('cart', []);
        $slug = $product->getSlug();

        if ($cart[$slug] == 0) {
            $cart[$slug] = 0 ;
        } else {
            $cart[$slug]--;
        }

        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function getAll()
    {
        $cartComplete = [];
        if ($this->get())
        {
            foreach ($this->get() as $slug => $quantity) {
                $product = $this->em
                    ->getRepository(Product::class)
                    ->findOneBy(['slug' => $slug]);
                if ($product)
                {
                    $cartComplete[] = [
                            'product' => $product,
                            'quantity' => $quantity
                        ];
                }   
               else 
               {
                   $cart = $this->session->get('cart');
                   unset($cart[$slug]);
               }
            }
        }
        
        return $cartComplete;
    }
    public function remove()
    {
        $this->session->remove('cart');
    }

    public function deleteItem(Product $product)
    {
        $cart = $this->session->get('cart');
        $slug = $product->getSlug();
        unset($cart[$slug]);
        return $this->session->set('cart', $cart);
    }
}