<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use \Symfony\Bundle\SecurityBundle\Security;

class MenuBuilder
{
    const LINK_ATTR_CLASS = 'block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent';

    private FactoryInterface $factory;
    private Security $security;
    private ItemInterface $menu;

    public function __construct(FactoryInterface $factory, Security $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    public function createMainMenu(array $options): ItemInterface
    {

        $this->menu = $this->factory->createItem('main', [
            'attributes' => ['class' => 'flex flex-col p-4 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700'],
        ]);

        $this->menu->addChild('Accueil', [
            'route' => 'home',
            'linkAttributes' => ['class' => self::LINK_ATTR_CLASS]

        ])
//            ->setExtra('icon', 'fa-solid fa-lock')
        ;


        $this->home();
        $this->security();
        $this->admin();



        return $this->menu;
    }

    public function home()
    {
        $this->menu->addChild('Accueil', [
            'route' => 'home',
            'linkAttributes' => ['class' => self::LINK_ATTR_CLASS]
        ]);
    }

    public function admin()
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
//            $this->menu->addChild('Connexion', [
//                'route' => 'admin',
//                'linkAttributes' => ['class' => self::LINK_ATTR_CLASS]
//
//            ]);
        }
    }

    public function security()
    {
        if ($this->security->isGranted('ROLE_USER')) {
            // TODO : Student route
        } else {
            $this->menu->addChild('Connexion', [
                'route' => 'login',
                'linkAttributes' => ['class' => self::LINK_ATTR_CLASS]
            ]);
        }
    }
}