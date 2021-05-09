<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/lington-admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Lington Beauty');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Tableau de Bord', 'fa fa-home');

        yield MenuItem::section('       ');
        yield MenuItem::linkToUrl('Retour sur le site', 'fa fa-blog', '/');
        yield MenuItem::linkToUrl('Retour dans la boutique', 'fa fa-store', '/shop');

        yield MenuItem::section('       ');
        yield MenuItem::subMenu('Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Ajouter un Utilisateur', 'fas fa-user-plus', User::class)
            ->setAction('new');

        yield MenuItem::section('       ');
        yield MenuItem::section('Produits');
        yield MenuItem::subMenu('Produits');
        yield MenuItem::linkToCrud('Produits', 'fas fa-barcode', Product::class);
        yield MenuItem::linkToCrud('Ajouter un produit', 'fas fa-cart-plus', Category::class)
            ->setAction('new');
        yield MenuItem::subMenu('Catégories');
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Ajouter une catégorie', 'fas fa-cart-plus', Category::class)
            ->setAction('new');
    }
}
