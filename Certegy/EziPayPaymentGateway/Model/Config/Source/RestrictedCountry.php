<?php
namespace Certegy\EziPayPaymentGateway\Model\Config\Source;

/**
 * Country config field renderer
 */
use Magento\Directory\Model\Config\Source\Country;

class RestrictedCountry extends \Magento\Directory\Model\Config\Source\Country 
{
    /**
     * @param \Magento\Directory\Model\ResourceModel\Country\Collection $countryCollection
     */
    public function __construct(\Magento\Directory\Model\ResourceModel\Country\Collection $countryCollection)
    {
        $countryCollection->addCountryIdFilter(array('AU', 'NZ'));
        
        parent::__construct($countryCollection);
    }
}
