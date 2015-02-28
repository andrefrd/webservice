<?php

class Smartwave_Porto_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    protected $_texturePath;
    
    public function __construct()
    {
        $this->_texturePath = 'wysiwyg/porto/texture/default/';
    }

    public function getCfgGroup($group, $storeId = NULL)
    {
        if ($storeId)
            return Mage::getStoreConfig('porto/' . $group, $storeId);
        else
            return Mage::getStoreConfig('porto/' . $group);
    }
    
    public function getCfgSectionDesign($storeId = NULL)
    {
        if ($storeId)
            return Mage::getStoreConfig('porto_design', $storeId);
        else
            return Mage::getStoreConfig('porto_design');
    }

    public function getCfgSectionSettings($storeId = NULL)
    {
        if ($storeId)
            return Mage::getStoreConfig('porto_settings', $storeId);
        else
            return Mage::getStoreConfig('porto_settings');
    }
    
    public function getTexturePath()
    {
        return $this->_texturePath;
    }

    public function getCfg($optionString)
    {
        return Mage::getStoreConfig('porto_settings/' . $optionString);
    }
     public function getImage($product, $imgWidth, $imgHeight, $imgVersion='small_image', $file=NULL) 
    {
        $url = '';
        if ($imgHeight <= 0)
        {
            $url = Mage::helper('catalog/image')
                ->init($product, $imgVersion, $file)
                //->constrainOnly(true)
                ->keepAspectRatio(true)
                //->setQuality(100)
                ->keepFrame(false)
                ->resize($imgWidth);
        }
        else
        {
            $url = Mage::helper('catalog/image')
                ->init($product, $imgVersion, $file)
                ->resize($imgWidth, $imgHeight);
        }
        return $url;
    }
    
    // get hover image for product
    public function getHoverImageHtml($product, $imgWidth, $imgHeight, $imgVersion='small_image') 
    {
        $product->load('media_gallery');
        $order = $this->getConfig('category/image_order');
        if ($gallery = $product->getMediaGalleryImages())
        {
            if ($hoverImage = $gallery->getItemByColumnValue('position', $order))
            {
                $url = '';
                if ($imgHeight <= 0)
                {
                    $url = Mage::helper('catalog/image')
                        ->init($product, $imgVersion, $hoverImage->getFile())
                        ->constrainOnly(true)
                        ->keepAspectRatio(true)
                        ->keepFrame(false)
                        ->resize($imgWidth);
                }
                else
                {
                    $url = Mage::helper('catalog/image')
                        ->init($product, $imgVersion, $hoverImage->getFile())
                        ->resize($imgWidth, $imgHeight);
                }
                return '<img class="hover-image" src="' . $url . '" alt="' . $product->getName() . '" />';
            }
        }
        
        return '';
    }
    public function getHomeUrl() {
        return array(
            "label" => $this->__('Home'),
            "title" => $this->__('Home Page'),
            "link" => Mage::getUrl('')
        );
    }
    public function getPreviousProduct()
    {
        $prodId = Mage::registry('current_product')->getId();
 
        $catArray = Mage::registry('current_category');
 
        if($catArray){
            $catArray = Mage::getResourceModel('catalog/category')->getProductsPosition($catArray);
            $keys = array_flip(array_keys($catArray));
            $values = array_keys($catArray);
 
            $productId = $values[$keys[$prodId]-1];
 
            $product = Mage::getModel('catalog/product');
 
            if($productId){
                $product->load($productId);
                return $product->getProductUrl();
            }
            return false;
        }
 
        return false;
 
    }
 
 
    public function getNextProduct()
    {
        $prodId = Mage::registry('current_product')->getId();
 
        $catArray = Mage::registry('current_category');
 
        if($catArray){
            $catArray = Mage::getResourceModel('catalog/category')->getProductsPosition($catArray);
            $keys = array_flip(array_keys($catArray));
            $values = array_keys($catArray);
 
            $productId = $values[$keys[$prodId]+1];
 
            $product = Mage::getModel('catalog/product');
 
            if($productId){
                $product->load($productId);
                return $product->getProductUrl();
            }
            return false;
        }
 
        return false;
    }
    public function getCompareUrl() {
        $_helper = Mage::helper("catalog/product_compare");
        return $_helper->getListUrl();
    }
}
