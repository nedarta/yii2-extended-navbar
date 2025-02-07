<?php

namespace nedarta\navbar;

use yii\bootstrap5\NavBar as BaseNavBar;
use yii\bootstrap5\Nav;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;

/**
 * ExtendedNavBar extends the Yii2 Bootstrap 5 NavBar widget with support for external items
 * and enhanced customization options.
 *
 * @property array $externalItems List of navigation items to display outside the collapsible section
 * @property array $externalOptions HTML options for the external items container
 * @property array $containerOptions HTML options for the inner container
 * @property string $dropdownClass Class name for dropdown menus
 * @property array $collapseOptions HTML options for the collapsible content
 * @property string $externalItemsPosition Position of external items ('left', 'right', 'beforeToggle')
 */
class ExtendedNavBar extends BaseNavBar
{
    // Valid positions for external items
    private const VALID_POSITIONS = ['left', 'right', 'beforeToggle'];
    
    /**
     * @var array External navigation items configuration
     */
    public array $externalItems = [];

    /**
     * @var array HTML options for external items container
     */
    public array $externalOptions = ['class' => 'navbar-nav me-auto'];

    /**
     * @var array HTML options for inner container
     */
    public array $containerOptions = ['class' => 'container-fluid'];

    /**
     * @var string Dropdown class for navigation menus
     */
    public string $dropdownClass = 'yii\bootstrap5\Dropdown';



    /**
     * @var string Position of external items
     */
    public string $externalItemsPosition = 'left';

    /**
     * @var array|null Cached filtered external items
     */
    private ?array $_filteredItems = null;

    /**
     * Initializes the widget and validates configuration
     * 
     * @throws InvalidConfigException if configuration is invalid
     */
    public function init(): void
    {
        parent::init();
        $this->validateConfiguration();
    }

    /**
     * Validates widget configuration
     * 
     * @throws InvalidConfigException if configuration is invalid
     */
    protected function validateConfiguration(): void
    {
        if (!in_array($this->externalItemsPosition, self::VALID_POSITIONS)) {
            throw new InvalidConfigException(sprintf(
                'Invalid externalItemsPosition value. Allowed values are: %s',
                implode(', ', self::VALID_POSITIONS)
            ));
        }

        if (!is_array($this->externalItems)) {
            throw new InvalidConfigException('External items must be an array');
        }
    }

    /**
     * Adds a new external navigation item
     * 
     * @param array|string $item Item configuration
     * @return self
     */
    public function addExternalItem($item): self
    {
        $this->externalItems[] = $item;
        $this->_filteredItems = null;
        return $this;
    }

    /**
     * Removes an external item by index
     * 
     * @param int $index Item index to remove
     * @return self
     */
    public function removeExternalItem(int $index): self
    {
        if (isset($this->externalItems[$index])) {
            unset($this->externalItems[$index]);
            $this->externalItems = array_values($this->externalItems);
            $this->_filteredItems = null;
        }
        return $this;
    }

    /**
     * Renders the navbar's inner container with all components
     * 
     * @return string Rendered HTML
     */
    protected function renderInnerContainer(): string
    {
        $containerOptions = $this->prepareContainerOptions();
        
        $html = Html::beginTag('div', $containerOptions) . "\n";
        $html .= $this->renderBrand() . "\n";
        $html .= $this->renderExternalItemsByPosition() . "\n";
        $html .= $this->renderCollapsibleContent() . "\n";
        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * Prepares container options with required classes
     * 
     * @return array Prepared options
     */
    protected function prepareContainerOptions(): array
    {
        $options = $this->containerOptions;
        Html::addCssClass($options, ['widget' => 'container-fluid']);
        return $options;
    }

    /**
     * Renders external items based on configured position
     * 
     * @return string Rendered HTML
     */
    protected function renderExternalItemsByPosition(): string
    {
        $html = '';
        
        if ($this->externalItemsPosition === 'left' || $this->externalItemsPosition === 'beforeToggle') {
            $html .= $this->renderExternalItems() . "\n";
        }

        $html .= $this->renderToggleButton() . "\n";

        if ($this->externalItemsPosition === 'right') {
            $html .= $this->renderExternalItems() . "\n";
        }

        return $html;
    }

    /**
     * Renders external navigation items
     * 
     * @return string Rendered HTML
     * @throws InvalidArgumentException if item configuration is invalid
     */
    protected function renderExternalItems(): string
    {
        if (empty($this->externalItems)) {
            return '';
        }

        $this->_filteredItems ??= $this->filterVisibleItems();

        if (empty($this->_filteredItems)) {
            return '';
        }

        $processedItems = $this->processExternalItems();
        return $this->renderNav($processedItems);
    }

    /**
     * Filters visible items from external items
     * 
     * @return array Filtered items
     */
    protected function filterVisibleItems(): array
    {
        return array_filter($this->externalItems, function ($item) {
            return !isset($item['visible']) || $item['visible'] === true;
        });
    }

    /**
     * Processes external items for rendering
     * 
     * @return array Processed items
     * @throws InvalidArgumentException if item configuration is invalid
     */
    protected function processExternalItems(): array
    {
        $processedItems = [];
        
        foreach ($this->_filteredItems as $item) {
            if (is_array($item)) {
                $processedItems[] = $item;
            } elseif (is_string($item)) {
                $processedItems[] = ['label' => $item, 'encode' => false];
            } else {
                throw new InvalidArgumentException(
                    'Invalid item configuration. Each item must be either an array or a string.'
                );
            }
        }

        return $processedItems;
    }

    /**
     * Renders Nav widget with processed items
     * 
     * @param array $items Processed items to render
     * @return string Rendered HTML
     */
    protected function renderNav(array $items): string
    {
        $options = $this->externalOptions;
        Html::addCssClass($options, ['widget' => 'navbar-nav']);

        return Nav::widget([
            'options' => $options,
            'items' => $items,
            'encodeLabels' => $this->encodeLabels,
            'dropdownClass' => $this->dropdownClass,
        ]);
    }

    /**
     * Renders collapsible content section
     * 
     * @return string Rendered HTML
     */
    protected function renderCollapsibleContent(): string
    {
        $options = $this->collapseOptions;
        Html::addCssClass($options, ['collapse' => 'navbar-collapse']);
        return Html::tag('div', $this->renderItems(), $options);
    }
}