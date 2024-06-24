<?php

declare(strict_types=1);

namespace Tests\FiftyDeg\SyliusScriptsPlugin\Behat\Page\Shop;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class HomePage extends SymfonyPage implements HomePageInterface
{
    public function getRouteName(): string
    {
        return 'sylius_shop_homepage';
    }

    public function getElementById(string $id): ?NodeElement
    {
        return $this->getSession()->getPage()->waitFor(3, function () use ($id): ?NodeElement {
            return $this->getDocument()->findById($id);
        });
    }
}
