<?php

namespace coderius\yii2SeoHelper\metaTagsClients;

use Yii;
use yii\base\Component;
use yii\base\View;

abstract class BaseMetaTagsClient extends Component{

    private $_metaTitle;
    private $_metaDesc;
    private $_metaKeywords;
    private $_url;
    private $_clientPrefix = '';

    /**
     * Get the value of _metaTitle
     */ 
    public function getMetaTitle()
    {
        return $this->_metaTitle;
    }

    /**
     * Set the value of _metaTitle
     *
     * @return  self
     */ 
    public function setMetaTitle($metaTitle)
    {
        $this->_metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get the value of _metaDesc
     */ 
    public function getMetaDesc()
    {
        return $this->_metaDesc;
    }

    /**
     * Set the value of _metaDesc
     *
     * @return  self
     */ 
    public function setMetaDesc($metaDesc)
    {
        $this->_metaDesc = $metaDesc;

        return $this;
    }

    /**
     * Get the value of _metaKeywords
     */ 
    public function getMetaKeywords()
    {
        return $this->_metaKeywords;
    }

    /**
     * Set the value of _metaKeywords
     *
     * @return  self
     */ 
    public function setMetaKeywords($metaKeywords)
    {
        $this->_metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get the value of _url
     */ 
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Set the value of _url
     *
     * @return  self
     */ 
    public function setUrl($url)
    {
        $this->_url = $url;

        return $this;
    }

    public function addMetaTags($metaData = [])
    {
        foreach($metaData as $prop => $value){
            
        }
    }

    public function registerInView(View $view)
    {

    }

    /**
     * Get the value of _clientPrefix
     */ 
    public function getClientPrefix()
    {
        return $this->_clientPrefix;
    }

    /**
     * Set the value of _clientPrefix
     *
     * @return  self
     */ 
    public function setClientPrefix($clientPrefix)
    {
        $this->_clientPrefix = $clientPrefix;

        return $this;
    }
}