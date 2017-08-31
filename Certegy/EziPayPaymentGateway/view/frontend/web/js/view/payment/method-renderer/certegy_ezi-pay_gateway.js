/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*browser:true*/
/*global define*/
define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/model/url-builder',
        'mage/url',
        'Magento_Checkout/js/model/quote',
    ],
    function (
        $,
        Component, 
        urlBuilder,
        url,
        quote) {
        'use strict';

        var self;

        return Component.extend({
            redirectAfterPlaceOrder: false,

            defaults: {
                template: 'Certegy_EziPayPaymentGateway/payment/form'
            },

            initialize: function() {
                this._super();
                self = this;
            },

            getCode: function() {
                return 'certegy_ezi-pay_gateway';
            },

            getData: function() {
                return {
                    'method': this.item.method
                };
            },

            afterPlaceOrder: function () {
                window.location.replace(url.build('ezipay/checkout/index'));
            },

            /*
             * This same validation is done server-side in InitializationRequest.validateQuote()
             */
            validate: function() {
                var billingAddress = quote.billingAddress();
                var shippingAddress = quote.shippingAddress();
                var allowedCountries = self.getAllowedCountries();
                var totals = quote.totals();
                var allowedCountriesArray = [];

                if(typeof(allowedCountries) == 'string' && allowedCountries.length > 0){
                    allowedCountriesArray = allowedCountries.split(',');
                }

                self.messageContainer.clear();

                if (!billingAddress) {
                    self.messageContainer.addErrorMessage({'message': 'Please enter your billing address'});
                    return false;
                }

                if (!billingAddress.firstname || 
                    !billingAddress.lastname ||
                    !billingAddress.street ||
                    !billingAddress.city ||
                    !billingAddress.postcode ||
                    billingAddress.firstname.length == 0 ||
                    billingAddress.lastname.length == 0 ||
                    billingAddress.street.length == 0 ||
                    billingAddress.city.length == 0 ||
                    billingAddress.postcode.length == 0) {
                    self.messageContainer.addErrorMessage({'message': 'Please enter your billing address details'});
                    return false;
                }

                if (allowedCountriesArray.indexOf(billingAddress.countryId) == -1 ||
                    allowedCountriesArray.indexOf(shippingAddress.countryId) == -1) {
                    self.messageContainer.addErrorMessage({'message': 'Orders from this country are not supported by Ezi-Pay. Please select a different payment option.'});
                    return false;
                }

                if (totals.grand_total < 20) {
                    self.messageContainer.addErrorMessage({'message': 'Ezi-Pay doesn\'t support purchases less than $20.'});
                    return false;
                }

                return true;
            },

            getTitle: function() {
                return window.checkoutConfig.payment.ezipay_gateway.title;
            },

            getDescription: function() {
                return window.checkoutConfig.payment.ezipay_gateway.description;
            },
            
            getEziPayLogo:function(){
                var logo = window.checkoutConfig.payment.ezipay_gateway.logo;

                return logo;
            },

            getAllowedCountries: function() {
                return window.checkoutConfig.payment.ezipay_gateway.allowed_countries;
            }

        });
    }
);