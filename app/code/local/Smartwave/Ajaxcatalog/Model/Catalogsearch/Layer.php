<?php

class Smartwave_Ajaxcatalog_Model_Catalogsearch_Layer extends Mage_CatalogSearch_Model_Layer 
{
    /**
     * Prepare product collection
     *
     * @param Mage_Catalog_Model_Resource_Eav_Resource_Product_Collection $collection
     * @return Mage_Catalog_Model_Layer
     */
    public function prepareProductCollection($collection)
    {
        $collection
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addSearchFilter(Mage::helper('catalogsearch')->getQuery()->getQueryText())
            ->setStore(Mage::app()->getStore())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addUrlRewrite();

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);
		
		$this->currentRate = $collection->getCurrencyRate();
		$max=$this->getMaxPriceFilter();
		$min=$this->getMinPriceFilter();

        $where = '1=1 ';
        if(isset($min) && $min){
            $where .= ' AND final_price >= "'.$min.'"';
        }
        if(isset($max) && $max){
            $where .= ' AND final_price <= "'.$max.'"';
        }
        $where ='('.$where.') OR (final_price is NULL)';
        $collection->getSelect()->where($where);
        
        return $collection;
    }
    
    
    /*
    * convert Price as per currency
    *
    * @return currency
    */
    public function getMaxPriceFilter(){
        if(isset($_GET['max']))
            return round($_GET['max']/$this->currentRate);
        return 0;
    }
    
}