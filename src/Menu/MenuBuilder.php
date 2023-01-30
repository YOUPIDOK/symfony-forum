<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use \Symfony\Bundle\SecurityBundle\Security;

class MenuBuilder
{
    private FactoryInterface $factory;
    private Security $security;

    public function __construct(FactoryInterface $factory, Security $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('main', [
            'attributes' => ['class' => 'navbar-nav']
        ]);

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $menu
                ->addChild('Accueil', [
                    'route' => 'home',
                    'attributes' => ['class' => 'nav-item'],
                    'linkAttributes' => ['class' => 'nav-link']
                ])
                ->setExtra('icon', 'fa-solid fa-lock')
            ;
        }

        return $menu;
    }
}