<?php

namespace nedarta\navbar;

use yii\bootstrap5\NavBar as BaseNavBar;
use yii\bootstrap5\Nav;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;

class ExtendedNavBar extends BaseNavBar
{
    /**
     * @var array list of external items to be displayed in the navbar.
     * Format: same as regular Nav items.
     * Example:
     * [
     *     ['label' => 'Login', 'url' => ['/site/login']],
     *     ['label' => 'Sign Up', 'url' => ['/site/signup']],
     *     Html::tag('li', Html::a('Custom HTML', '#', ['class' => 'nav-link']), ['class' => 'nav-item']),
     * ]
     */
    public array $externalItems = [];

    /**
     * @var array HTML options for the external items container.
     * Default: ['class' => 'navbar-nav me-auto']
     */
    public array $externalOptions = ['class' => 'navbar-nav me-auto'];

    /**
     * @var array HTML options for the inner container div.
     * Default: ['class' => 'container-fluid']
     */
    public array $containerOptions = ['class' => 'container-fluid'];

    /**
     * @var string the class for dropdowns used in the external items.
     * Default: 'yii\bootstrap5\Dropdown'
     */
    public string $dropdownClass = 'yii\bootstrap5\Dropdown';

    /**
     * @var array HTML options for the collapsible content section.
     * Default: ['id' => 'navbarCollapse']
     */
    public array $collapseOptions = ['id' => 'navbarCollapse'];

    /**
     * @var string position of external items relative to the toggle button.
     * Options: 'left', 'right', 'beforeToggle'
     * Default: 'left'
     */
    public string $externalItemsPosition = 'left';

    /**
     * @var array|null Cached filtered external items
     */
    private ?array $_filteredItems = null;

    /**
     * {@inheritdoc}
     * @throws InvalidConfigException if configuration is invalid
     */
    public function init(): void
    {
        parent::init();
        
        if (!in_array($this->externalItemsPosition, ['left', 'right', 'beforeToggle'])) {
            throw new InvalidConfigException('Invalid externalItemsPosition value. Allowed values are: left, right, beforeToggle');
        }

        if (!is_array($this->externalItems)) {
            throw new InvalidConfigException('External items must be an array');
        }
    }

    /**
     * Adds a new external item to the navbar
     * @param array|string $item The item to add
     * @return self
     */
    public function addExternalItem($item): self
    {
        $this->externalItems[] = $item;
        $this->_filteredItems = null; // Reset cache
        return $this;
    }

    /**
     * Removes an external item by index
     * @param int $index The index of the item to remove
     * @return self
     */
    public function removeExternalItem(int $index): self
    {
        if (isset($this->externalItems[$index])) {
            unset($this->externalItems[$index]);
            $this->externalItems = array_values($this->externalItems);
            $this->_filteredItems = null; // Reset cache
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function renderInnerContainer(): string
    {
        $containerOptions = $this->containerOptions;
        Html::addCssClass($containerOptions, ['widget' => 'container-fluid']);

        $html = Html::beginTag('div', $containerOptions) . "\n";
        $html .= $this->renderBrand() . "\n";

        // Render external items based on position
        if ($this->externalItemsPosition === 'left' || $this->externalItemsPosition === 'beforeToggle') {
            $html .= $this->renderExternalItems() . "\n";
        }

        $html .= $this->renderToggleButton() . "\n";

        if ($this->externalItemsPosition === 'right') {
            $html .= $this->renderExternalItems() . "\n";
        }

        $html .= $this->renderCollapsibleContent() . "\n";
        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * Renders external items.
     * @return string The rendered HTML
     * @throws InvalidArgumentException if item configuration is invalid
     */
    protected function renderExternalItems(): string
    {
        if (empty($this->externalItems)) {
            return '';
        }

        // Use cached filtered items or create new cache
        if ($this->_filteredItems === null) {
            $this->_filteredItems = array_filter($this->externalItems, function ($item) {
                return !isset($item['visible']) || $item['visible'] === true;
            });
        }

        if (empty($this->_filteredItems)) {
            return '';
        }

        // Process items to handle custom HTML
        $processedItems = [];
        foreach ($this->_filteredItems as $item) {
            if (is_array($item)) {
                $processedItems[] = $item;
            } elseif (is_string($item)) {
                $processedItems[] = ['label' => $item, 'encode' => false];
            } else {
                throw new InvalidArgumentException('Invalid item configuration. Each item must be either an array or a string.');
            }
        }

        $options = $this->externalOptions;
        Html::addCssClass($options, ['widget' => 'navbar-nav']);

        return Nav::widget([
            'options' => $options,
            'items' => $processedItems,
            'encodeLabels' => $this->encodeLabels,
            'dropdownClass' => $this->dropdownClass,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function renderCollapsibleContent(): string
    {
        $options = $this->collapseOptions;
        Html::addCssClass($options, ['collapse' => 'navbar-collapse']);
        return Html::tag('div', $this->renderItems(), $options);
    }
}