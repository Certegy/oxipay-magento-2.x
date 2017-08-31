<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Certegy\EziPayPaymentGateway\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetupFactory;

class InstallData implements InstallDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Prepare database for install
         */
        $setup->startSetup();

        // add default Oxipay Status "Oxipay Processed" for STATE_PROCESSING state
        $statusTable = 'sales_order_status';
        $statusStateTable = 'sales_order_status_state';
        $epProcessingStatus = 'ep_processed';
        $processingState  = \Magento\Sales\Model\Order::STATE_PROCESSING;

        //Insert 'oxipay_processed' status
        $setup->getConnection()->insertArray(
            $statusTable,
            array('status', 'label'),
            array(array('status' => $epProcessingStatus, 'label' => 'Certegy Ezi-Pay Processed'))
        );

        //Associate 'oxipay_processed' status with STATE_PROCESSING state
        $setup->getConnection()->insertArray(
            $statusStateTable,
            array('status', 'state', 'is_default', 'visible_on_front'),
            array(array('status' => $epProcessingStatus, 'state' => $processingState, 'is_default' => 0, 'visible_on_front' => 1))
        );

        /**
         * Prepare database after install
         */
        $setup->endSetup();
    }
}