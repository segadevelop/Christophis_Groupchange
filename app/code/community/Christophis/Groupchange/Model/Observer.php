<?php
    class Christophis_Groupchange_Model_Observer
    {
        public function changeUserGroup(Varien_Event_Observer $observer)
        {
            //$customer = $observer->getCustomer();

            $special_cat = 11; // Special product category
            $customerId = Mage::getSingleton('customer/session')->getCustomerId();
            $lastOrderId = Mage::getSingleton('checkout/session')->getLastOrderId();
            $order = Mage::getSingleton('sales/order');
            $order->load($lastOrderId);
            $allitems = $order->getAllItems();
            foreach ($allitems as $item) {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $categoryIds = $product->getCategoryIds();
                if (in_array($special_cat, $categoryIds)) {
                    $mem_group_id = $item->getSku();  // $item->getSku() is customer group name
                    $customer_detail = Mage::getSingleton('customer/session')->getCustomer();
                    $customer_detail->setGroupId($mem_group_id);
                    $customer_detail->save();
                }
            }
        }
    }
