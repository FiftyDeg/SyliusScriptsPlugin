<?php

declare(strict_types=1);

namespace Tests\FiftyDeg\SyliusScriptsPlugin\Behat\Page\Shop;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface HomePageInterface extends SymfonyPageInterface
{
    public function getElementById(string $id): ?NodeElement;
}
