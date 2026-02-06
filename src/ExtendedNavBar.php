<?php

namespace nedarta\navbar;

use yii\bootstrap5\NavBar as BaseNavBar;
use yii\bootstrap5\Nav;
use yii\base\InvalidConfigException;

/**
 * ExtendedNavBar extends the default Bootstrap5 NavBar widget
 * to support items rendered outside of the collapse/drawer container.
 *
 * @property string $externalItems Items to be rendered outside of collapse/drawer
 */
class ExtendedNavBar extends BaseNavBar
{
    /**
     * @var string Additional items to be rendered outside of collapse/drawer
     */
    public $externalItems = '';

    /**
     * @var array External items in array format. Supports either a plain item list or a full Nav widget config.
     */
    public $externalItemsArray = [];

    /**
     * @var string Where external items are rendered relative to the toggle button: "before" or "after".
     */
    public $externalItemsPosition = 'before';

    /**
     * @var bool Whether active route highlighting should be enabled for $externalItemsArray rendering.
     */
    public $highlightActiveItems = true;

    /**
     * {@inheritDoc}
     */
    public function init(): void
    {
        parent::init();

        if (!in_array($this->externalItemsPosition, ['before', 'after'], true)) {
            throw new InvalidConfigException('The "externalItemsPosition" property must be either "before" or "after".');
        }
    }
    
    /**
     * {@inheritDoc}
     */
    protected function renderToggleButton(): string
    {
        // Store toggle button HTML first
        $toggleButton = parent::renderToggleButton();

        $externalItems = $this->renderExternalItems();

        if ($this->externalItemsPosition === 'after') {
            return $toggleButton . ($externalItems !== '' ? "\n" . $externalItems : '');
        }

        return ($externalItems !== '' ? $externalItems . "\n" : '') . $toggleButton;
    }

    /**
     * Renders external navbar items from array config or raw HTML.
     */
    protected function renderExternalItems(): string
    {
        if (!empty($this->externalItemsArray)) {
            return Nav::widget($this->buildExternalNavConfig());
        }

        return (string) $this->externalItems;
    }

    /**
     * Builds the Nav widget configuration for external item arrays.
     */
    protected function buildExternalNavConfig(): array
    {
        $config = $this->externalItemsArray;

        if (array_is_list($config)) {
            $config = ['items' => $config];
        }

        $config['activateItems'] = $this->highlightActiveItems;

        return $config;
    }
}
