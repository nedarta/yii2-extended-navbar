# Yii2 Extended NavBar Widget

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/nedarta/yii2-extended-navbar)](https://packagist.org/packages/nedarta/yii2-extended-navbar)

A Bootstrap 5-compatible NavBar widget for Yii2 that adds support for external navigation items and enhanced customization options.

## Key Features

- Bootstrap 5 compatibility with modern navbar styling
- External navigation items that remain visible outside the collapsible section
- Flexible positioning options for external items (before or after the toggle)
- Support for dynamic dropdowns in both regular and external items
- Comprehensive customization options for all navbar elements
- Optional active route highlighting for external items rendered from arrays

## Installation

```bash
composer require nedarta/yii2-extended-navbar
```

## Basic Usage

```php
use nedarta\navbar\ExtendedNavBar;
use yii\helpers\Html;

echo ExtendedNavBar::widget([
    'brandLabel' => 'My Company',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-expand-lg navbar-light bg-light',
    ],
    'externalItems' => Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto d-flex flex-row gap-2 me-3'], //configure as needed
        'items' => [
            ['label' => 'EN', 'url' => ['/site/language', 'lang' => 'en']],
            ['label' => 'LV', 'url' => ['/site/language', 'lang' => 'lv']],
        ],
    ]),
]); ?>

## Array-Based External Items (with active highlighting)

```php
echo ExtendedNavBar::widget([
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
```

<?= Nav::widget([
    'options' => ['class' => 'navbar-nav ms-auto'],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ],
]);
```

## Configuration Options

- `externalItems` (`string`): Raw pre-rendered HTML for items outside the collapse area.
- `externalItemsArray` (`array`): External items as an array. Can be either:
  - a plain Yii Nav items list, or
  - a full `yii\bootstrap5\Nav::widget()` config.
- `externalItemsPosition` (`string`): `before` (default) or `after` the toggle button.
- `highlightActiveItems` (`bool`): Enables active route highlighting when using `externalItemsArray`.

### External Items Structure

Each external item can be:

```php
// Simple link
['label' => 'Home', 'url' => ['/site/index']]

// Dropdown menu
[
    'label' => 'Account',
    'items' => [
        ['label' => 'Profile', 'url' => ['/user/profile']],
        ['label' => 'Settings', 'url' => ['/user/settings']],
        '<hr class="dropdown-divider">',
        ['label' => 'Logout', 'url' => ['/site/logout']],
    ],
]

// Custom HTML
Html::tag('li', 
    Html::a('<i class="fas fa-user"></i>', ['/profile'], ['class' => 'nav-link']), 
    ['class' => 'nav-item']
)
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

- Create an issue in the GitHub repository
- Contact the maintainer at [GitHub](https://github.com/nedarta)

---
Developed with ❤️ by Edgars Karlsons (nedarta)
