<?php 

namespace coderius\yii2SeoHelper\metaTagsClients;

use Yii;
use yii\base\Component;


class Facebook extends BaseMetaTagsClient implements MetaTagsClientInterface
{
    /**
     * -------------------
     * Allowed props names
     *--------------------
     */
    private $_app_id;
    private $_title;
    private $_description;
    private $_image;
    private $_type;
    private $_url;
    
    
    protected $_clientPrefix = 'og:';
    protected $_clientMetaAttributeName = 'property';

    /**
     * Get the value of $_app_id
     */ 
    public function getAppId()
    {
        return $this->_app_id;
    }

    /**
     * Set the value of $_app_id
     *
     * @return  self
     */ 
    public function setAppId($appId)
    {
        $this->_app_id = $appId;

        return $this;
    }
    

    /**
     * Get the value of _title
     */ 
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Set the value of _title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->_title = $title;

        return $this;
    }

    /**
     * Get the value of _description
     */ 
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Set the value of _description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->_description = $description;

        return $this;
    }

    /**
     * Get the value of _image
     */ 
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * Set the value of _image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->_image = $image;

        return $this;
    }

    /**
     * Get the value of _type
     */ 
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Set the value of _type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->_type = $type;

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
}