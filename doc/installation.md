## Installation

1. Install with Composer
```bash
composer require fifty-deg/sylius-scripts-plugin
```

2. Add `FiftyDeg\SyliusScriptsPlugin\FiftyDegSyliusScriptsPlugin::class => ['all' => true],` into `/config/bundles.php`

3. Register vendor settings by adding the following code snippet in `config/routes.yaml`:  

```yaml
fiftydeg_sylius_scripts_plugin:
    resource: "@FiftyDegSyliusScriptsPlugin/Resources/config/routes.yaml"
```
4. Create the `fiftydeg_sylius_scripts.yaml` file in `<project_root>/config/packages`

5. In `fiftydeg_sylius_scripts.yaml` define the sylius template events where to allow scripts injection like in the example below
```yaml
fifty_deg_sylius_scripts:
    template_events: [
        {label: 'Head', value: 'sylius.shop.layout.head'},
        {label: 'Before body', value: 'sylius.shop.layout.before_body'},
        {label: 'After body', value: 'sylius.shop.layout.after_body'},
        {label: 'Homepage', value: 'sylius.shop.homepage'},
    ]

```
6. Template events will be shown in the `Embed Code > Scripts` admin menu.
---
<br/>

<ul>
<li><a href="./installation.md">Installation</a></li>
<li><a href="./development.md">Development</a></li>
<li><a href="./testing.md">Testing</a></li>
</ul>