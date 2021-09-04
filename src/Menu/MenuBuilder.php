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

    public function adminPanelMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('pages.admin_panel.song_add', ['route' => 'admin_panel_song_add']);
        $menu->addChild('pages.admin_panel.artist_add', ['route' => 'admin_panel_artist_add']);
        $menu->addChild('pages.admin_panel.album_add', ['route' => 'admin_panel_album_add']);
        $menu->addChild('pages.admin_panel.user_management', ['route' => 'admin_panel_user_list']);

        return $menu;
    }
}