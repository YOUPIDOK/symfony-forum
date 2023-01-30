<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use \Symfony\Bundle\SecurityBundle\Security;

class MenuBuilder
{
    const ARIA_CURRENT = 'page';

    private FactoryInterface $factory;
    private Security $security;

    const LINK_ATTR_CLASS = 'block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent';

    public function __construct(FactoryInterface $factory, Security $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    public function createMainMenu(array $options): ItemInterface
    {

        $menu = $this->factory->createItem('main', [
            'attributes' => ['class' => 'flex flex-col p-4 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700'],
        ]);

        $menu
            ->addChild('Accueil', [
                'route' => 'home',
                'linkAttributes' => ['class' => self::LINK_ATTR_CLASS]
            ]);

        $menu
            ->addChild('Test', [
                'route' => 'test',
                'linkAttributes' => ['class' => self::LINK_ATTR_CLASS]
            ])
//            ->setExtra('icon', 'fa-solid fa-lock')
        ;

        return $menu;
    }
}