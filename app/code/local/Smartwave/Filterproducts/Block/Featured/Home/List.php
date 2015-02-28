<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of List
 *
 * @author om
 */
class Smartwave_Filterproducts_Block_Featured_Home_List extends Smartwave_Filterproducts_Block_Featured_List
{
		protected function _getProductCollection()
    	{
        
        $storeId    = Mage::app()->getStore()->getId();
        
        $category_id = $this->getCategoryId();
        
        if($category_id) {
            $category = Mage::getModel('catalog/category')->load($category_id);    
            
            $products = Mage::getModel('catalog/product')->getCollection()
            ->addCategoryFilter($category)
            ->addAttributeToFilter(array(array('attribute' => 'featured', 'eq' => '1')))
            ->addAttributeToSort('created_at', 'desc')
            ->addAttributeToSelect('*')
            ->addAttributeToSelect(array('name', 'price', 'small_image'))
            ->setStoreId($storeId)
            ->addStoreFilter($storeId);

        }
        else {
            $products = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter(array(array('attribute' => 'featured', 'eq' => '1')))
            ->addAttributeToSort('created_at', 'desc')
            ->addAttributeToSelect('*')
            ->addAttributeToSelect(array('name', 'price', 'small_image'))
            ->setStoreId($storeId)
            ->addStoreFilter($storeId);
        }
        
        $product_count = $this->getProductCount();
            
        if($product_count)
        {
            $products->setPageSize($product_count);
        }


        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $store = Mage::app()->getStore();
        $code  = $store->getCode();
        if(!Mage::getStoreConfig("cataloginventory/options/show_out_of_stock", $code))
            Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($products); 

        $this->_productCollection = $products;

        return $this->_productCollection;
    	}
		
		
		public function getToolbarHtml()
    	{
        
    	}
}