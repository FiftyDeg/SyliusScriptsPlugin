<?php

declare(strict_types=1);

namespace Tests\FiftyDeg\SyliusScriptsPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\FiftyDeg\SyliusScriptsPlugin\Behat\Page\Shop\HomePageInterface;
use Webmozart\Assert\Assert;

final class RenderingScriptsContext implements Context
{
    public function __construct(
        private HomePageInterface $page,
    ) {
    }

    /**
     * @When a customer visits the homepage
     */
    public function whenCustomerVisitsHomePage(): void
    {
        $this->page->open();
    }

    /**
     * @Then the script with id :scriptId is found in page
     */
    public function thenTheScriptIsFoundInPage(string $scriptId): void
    {
        $appendedScript = $this->page->getElementById($scriptId);

        Assert::notNull($appendedScript, $scriptId);
    }
}
