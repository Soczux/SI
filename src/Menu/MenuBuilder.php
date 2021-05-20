<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function mainMenu(array $option): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('song', ['route' => 'songs']);
        $menu->addChild('album', ['route' => 'albums']);
        $menu->addChild('artist', ['route' => 'artists']);

        return $menu;
    }

    public function loginMenu(array $option): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('registration', ['route' => 'registration']);
        $menu->addChild('login', ['route' => 'login']);

        return $menu;
    }
}