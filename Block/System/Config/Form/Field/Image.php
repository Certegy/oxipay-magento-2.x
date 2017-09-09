<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Image config field renderer
 */
namespace Certegy\EzipayPaymentGateway\Block\System\Config\Form\Field;

/**
 * Class Image Field
 * @method getFieldConfig()
 * @method setFieldConfig()
 */
class Image extends \Magento\Config\Block\System\Config\Form\Field 
{
    /**
     * Get country selector html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '';

        if (!(string)$element->getValue()) {
            $defaultImage = $this->getViewFileUrl('Certegy_EzipayPaymentGateway::images/ezipay_logo.png');
            
            $html .= '<img src="' . $defaultImage . '" alt="Certegy Ezi-Pay logo" height="50" width="185" class="small-image-preview v-middle" />';
            
        }

        //the standard image preview is very small- bump the height up a bit and remove the width
        $html .= str_replace('height="22" width="22"', 'height="50"', parent::_getElementHtml($element));

        return $html;
    }
}
