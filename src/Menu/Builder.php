<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function MyMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'home']);
        $menu->addChild('Products', ['route' => '/products']);
        $menu->addChild('Blog', ['route' => '#']);
        $menu->addChild('Contact', ['route' => '#']);
        // ... etc

        return $menu;
    }
}