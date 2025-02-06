# Yii2 Extended NavBar Widget

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/nedarta/yii2-extended-navbar)](https://packagist.org/packages/nedarta/yii2-extended-navbar)

A Bootstrap 5-compatible NavBar widget for Yii2 that adds support for external navigation items and enhanced customization options.

## Key Features

- Bootstrap 5 compatibility with modern navbar styling
- External navigation items that remain visible outside the collapsible section
- Flexible positioning options for external items (left, right, or before toggle)
- Support for dynamic dropdowns in both regular and external items
- Comprehensive customization options for all navbar elements

## Installation

```bash
composer require nedarta/yii2-extended-navbar
```

## Basic Usage

```php
use nedarta\navbar\ExtendedNavBar;
use yii\helpers\Html;

echo ExtendedNavBar::widget([
    'brandLabel' => 'My Application',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark bg-dark',
    ],
    'externalItems' => [
        ['label' => 'Login', 'url' => ['/site/login']],
        ['label' => 'Register', 'url' => ['/site/register']],
    ],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
    ],
]);
```

## Configuration Options

### Core Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `externalItems` | array | `[]` | Navigation items displayed outside the collapsible section |
| `externalItemsPosition` | string | `'left'` | Position of external items (`'left'`, `'right'`, `'beforeToggle'`) |
| `externalOptions` | array | `['class' => 'navbar-nav me-auto']` | HTML options for external items container |
| `containerOptions` | array | `['class' => 'container-fluid']` | HTML options for the navbar's inner container |
| `collapseOptions` | array | `['id' => 'navbarCollapse']` | HTML options for collapsible content section |
| `dropdownClass` | string | `'yii\bootstrap5\Dropdown'` | Class used for dropdown menus |

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

## Advanced Examples

### Responsive Navigation with Mixed Content

```php
echo ExtendedNavBar::widget([
    'brandLabel' => Html::img('@web/logo.png', ['height' => '30']),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-light bg-light sticky-top',
    ],
    'externalItemsPosition' => 'right',
    'externalItems' => [
        Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/site/login']]
        ) : [
            'label' => Yii::$app->user->identity->username,
            'items' => [
                ['label' => 'Profile', 'url' => ['/user/profile']],
                ['label' => 'Logout', 'url' => ['/site/logout']],
            ],
        ],
        [
            'label' => '<i class="fas fa-bell"></i>',
            'encode' => false,
            'url' => ['/notifications'],
            'linkOptions' => ['class' => 'position-relative'],
        ],
    ],
    'items' => [
        ['label' => 'Dashboard', 'url' => ['/dashboard']],
        ['label' => 'Projects', 'url' => ['/projects']],
        ['label' => 'Reports', 'url' => ['/reports']],
    ],
]);
```

### Custom Styling with Bootstrap 5

```php
echo ExtendedNavBar::widget([
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark bg-gradient',
        'style' => 'background-color: #2c3e50;',
    ],
    'containerOptions' => [
        'class' => 'container-fluid px-4',
    ],
    'externalOptions' => [
        'class' => 'navbar-nav ms-auto mb-2 mb-lg-0',
    ],
    'collapseOptions' => [
        'class' => 'collapse navbar-collapse justify-content-center',
    ],
]);
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