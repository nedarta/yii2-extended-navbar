# Yii2 Extended NavBar Widget

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/nedarta/yii2-extended-navbar)](https://packagist.org/packages/nedarta/yii2-extended-navbar)

`nedarta/yii2-extended-navbar` provides an extended Bootstrap 5 `NavBar` for Yii2 with support for rendering additional navigation items outside the collapsible container.

## Features

- Built on top of `yii\bootstrap5\NavBar`
- Render extra items outside the collapse area (`externalItems`)
- Configure extra items as a plain array or full `Nav::widget()` config (`externalItemsArray`)
- Control whether extra items appear before or after the toggle button (`externalItemsPosition`)
- Optional active route highlighting for array-based external items (`highlightActiveItems`)

## Installation

```bash
composer require nedarta/yii2-extended-navbar
```

## Basic Usage

```php
<?php

use nedarta\navbar\ExtendedNavBar;
use yii\bootstrap5\Nav;

ExtendedNavBar::begin([
    'brandLabel' => 'My Company',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-expand-lg navbar-light bg-light',
    ],
    'externalItems' => Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto d-flex flex-row gap-2 me-3'],
        'items' => [
            ['label' => 'EN', 'url' => ['/site/language', 'lang' => 'en']],
            ['label' => 'LV', 'url' => ['/site/language', 'lang' => 'lv']],
        ],
    ]),
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav me-auto mb-2 mb-lg-0'],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ],
]);

ExtendedNavBar::end();
```

## Array-Based External Items

```php
<?php

use nedarta\navbar\ExtendedNavBar;
use yii\bootstrap5\Nav;

ExtendedNavBar::begin([
    'externalItemsPosition' => 'after',
    'highlightActiveItems' => true,
    'externalItemsArray' => [
        'options' => ['class' => 'navbar-nav ms-auto d-flex flex-row gap-2 me-3'],
        'items' => [
            ['label' => 'Profile', 'url' => ['/user/profile']],
            ['label' => 'Settings', 'url' => ['/user/settings']],
        ],
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav me-auto'],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
    ],
]);

ExtendedNavBar::end();
```

You can also pass `externalItemsArray` as a plain list of items; it will be wrapped as:

```php
['items' => [/* your items */]]
```

## Configuration

| Property | Type | Default | Description |
| --- | --- | --- | --- |
| `externalItems` | `string` | `''` | Pre-rendered HTML rendered outside the collapse container. |
| `externalItemsArray` | `array` | `[]` | External items config. Accepts either a plain item list or full `Nav::widget()` config. |
| `externalItemsPosition` | `string` | `'before'` | Position of external items relative to toggle button: `'before'` or `'after'`. |
| `highlightActiveItems` | `bool` | `true` | Sets `activateItems` for array-based external items rendering. |

## Notes

- `externalItemsArray` takes precedence over `externalItems` when both are set.
- Invalid `externalItemsPosition` values throw `yii\base\InvalidConfigException`.

## Contributing

1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/my-change`).
3. Commit your changes.
4. Push your branch.
5. Open a Pull Request.

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE).
