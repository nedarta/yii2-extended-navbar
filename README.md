# Yii2 Extended NavBar Widget

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/nedarta/yii2-extended-navbar)](https://packagist.org/packages/nedarta/yii2-extended-navbar)

An extended NavBar widget for Yii2 with support for external items and Bootstrap 5.

## Features

- **External Items**: Add custom items outside the collapsible section of the navbar.
- **Bootstrap 5 Support**: Fully compatible with Bootstrap 5.
- **Customizable**: Easily customize the navbar's appearance and behavior.
- **Dropdown Support**: Supports dropdown menus in external items.

## Installation

Install the extension via [Composer](https://getcomposer.org/):

```bash
composer require nedarta/yii2-extended-navbar
```

## Usage
### Basic Usage

Use the ExtendedNavBar widget in your Yii2 views:

```php
use nedarta\navbar\ExtendedNavBar;

echo ExtendedNavBar::widget([
    'brandLabel' => 'My Application',
    'brandUrl' => Yii::$app->homeUrl,
    'externalItems' => [
        ['label' => 'Login', 'url' => ['/site/login']],
        ['label' => 'Sign Up', 'url' => ['/site/signup']],
    ],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
    ],
]);
```

### Advanced Usage
You can customize the navbar further by using the available options:

```php
echo ExtendedNavBar::widget([
    'brandLabel' => 'My App',
    'brandUrl' => '/',
    'externalItems' => [
        ['label' => 'GitHub', 'url' => 'https://github.com', 'linkOptions' => ['target' => '_blank']],
        [
            'label' => 'Dropdown',
            'items' => [
                ['label' => 'Action 1', 'url' => ['/site/action1']],
                ['label' => 'Action 2', 'url' => ['/site/action2']],
            ],
        ],
    ],
    'externalOptions' => ['class' => 'navbar-nav ms-auto'], // Align external items to the right
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index'], 'active' => true],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ],
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark bg-dark shadow-sm',
    ],
]);
```

### Available options

| Option                  | Type   | Description |
|-------------------------|--------|-------------|
| `externalItems`         | array  | List of external items to display outside the collapsible section. |
| `externalOptions`       | array  | HTML options for the external items container. Default: `['class' => 'navbar-nav me-auto']`. |
| `containerOptions`      | array  | HTML options for the inner container div. Default: `['class' => 'container-fluid']`. |
| `dropdownClass`         | string | The class for dropdowns used in external items. Default: `yii\bootstrap5\Dropdown`. |
| `collapseOptions`       | array  | HTML options for the collapsible content section. Default: `['id' => 'navbarCollapse']`. |
| `externalItemsPosition` | string | Position of external items relative to the toggle button. Options: `left`, `right`, `beforeToggle`. Default: `left`. |

## Examples
### Custom HTML in External Items
You can include custom HTML in the `externalItems` array:

```php
echo ExtendedNavBar::widget([
    'externalItems' => [
        Html::tag('li', Html::a('Custom HTML', '#', ['class' => 'nav-link']), ['class' => 'nav-item']),
    ],
]);
```

### Conditional Visibility
Use the `visible` key to conditionally display items:

```php
echo ExtendedNavBar::widget([
    'externalItems' => [
        ['label' => 'Admin', 'url' => ['/admin'], 'visible' => Yii::$app->user->can('admin')],
    ],
]);
```

## License
This project is licensed under the MIT License. See the LICENSE file for details.

## Support
If you have any questions or issues, please open an issue.

Developed by Edgars Karlsons (nedarta).