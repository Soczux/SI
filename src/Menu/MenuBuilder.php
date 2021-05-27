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

        $menu->addChild('pages.songs', ['route' => 'songs']);
        $menu->addChild('pages.albums', ['route' => 'albums']);
        $menu->addChild('pages.artists', ['route' => 'artists']);

        return $menu;
    }

    public function loginMenu(array $option): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('pages.registration', ['route' => 'registration']);
        $menu->addChild('pages.login', ['route' => 'login']);

        return $menu;
    }
}