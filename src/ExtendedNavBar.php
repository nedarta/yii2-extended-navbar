<?php

namespace nedarta\navbar;

use yii\bootstrap5\NavBar as BaseNavBar;
use yii\bootstrap5\Html;

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
     * {@inheritDoc}
     */
    protected function renderToggleButton(): string
    {
        // Store toggle button HTML first
        $toggleButton = parent::renderToggleButton();
        
        // Build the complete HTML: external items + toggle button
        $html = '';
        if ($this->externalItems) {
            $html .= $this->externalItems . "\n";
        }
        $html .= $toggleButton;
        
        return $html;
    }
}