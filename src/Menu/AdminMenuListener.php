<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addShopSettingsMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu->getChild('fd_scripts') ?? $menu->addChild('fd_scripts')->setLabel('Embed code');

        $newSubmenu
            ->addChild('shop-settings-fifty-deg-scripts-script-index', [
                'route' => 'fiftydeg_admin_sylius_scripts_plugin_entity_script_index',
            ])
            // TODO: add translation
            ->setLabel('Scripts')
            ->setLabelAttribute('icon', 'code')
        ;
    }
}
