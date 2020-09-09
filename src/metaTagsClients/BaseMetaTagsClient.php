<?php

namespace coderius\yii2SeoHelper\metaTagsClients;

use Yii;
use yii\base\Component;
use yii\base\View;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\base\UnknownPropertyException;

abstract class BaseMetaTagsClient extends Component{

    private $_id;
    protected $_clientPrefix = [];
    protected $_clientMetaAttributeName = 'name';
    protected $_clientMetaAttributeContent = 'content';
    protected $properties = [];
    protected $allowedProps = [];
    /**
     * Generates service name.
     * @return string service name.
     */
    protected function defaultName()
    {
        return Inflector::camel2id(StringHelper::basename(get_class($this)));
    }

    /**
     * @param string $id service id.
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string service id
     */
    public function getId()
    {
        if (empty($this->_id)) {
            $this->_id = $this->defaultName();
        }

        return $this->_id;
    }
    

    /**
     * Generate meta tags string. Examples:
     * - site meta
     *  `<meta name="keywords" content="react clocks">`
     * or 
     * - facebook meta
     * `<meta property="og:type" content="website">`
     *
     * @param array $metaData
     * @return void
     */
    public function addMetaTags($metaData = [])
    {
        foreach($metaData as $prop => $content){
            $this->addMetaTag($prop, $content);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $prop
     * @param string $content
     * 
     * @return self|UnknownPropertyException
     */
    public function addMetaTag($prop, $content)
    {
        $prop = $this->normalizeProp($prop);
        
        if ($this->isPropAllow($prop)) {
            $this->setProp($prop, $content);
            return $this;
        }

        throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $prop);
    }

    public function getProp($prop)
    {
        return $this->properties[$prop];
    }

    protected function setProp($prop, $content){
        $this->properties[$prop] = $content;
    }

    public function getProps()
    {
        return $this->properties;
    }

    /**
     * Normalize prop name from string. 
     * Example:
     * From string like `og:type` return `type`
     *
     * @param string $prop
     * @return string
     */
    protected function normalizeProp($prop){
        $prefixes = $this->getClientPrefix();
        foreach($prefixes as $prefix){
            if (substr($prop, 0, strlen($prefix)) == $prefix) {
                $prop = substr($prop, strlen($prefix));
            }
        }
        
        return $prop;
    }

    public function registerInView(View $view)
    {
        $props = $this->getProps();
        if(is_array($props) && !empty($props)){
            foreach($props as $prop => $content){
                $propValue = $this->turnClientMetaAttributeValue($prop);
                
                Yii::$app->view->registerMetaTag([
                    $this->getClientMetaAttributeName() => $propValue, // like for facebook 'property' => 'og:type'
                    $this->getClientMetaAttributeContent() => $content, // like for facebook 'content' => 'website'
                ], $propValue);
            }
        }
        
    }

    /**
     * ------------------
     * Indernal methods
     *-------------------
     */

    protected function isPropAllow($name)
    {
        var_dump($this->allowedProps);
        return in_array($name, $this->getAllowedProps());
    }

    /**
     * Get the value of _clientPrefix
     */ 
    protected function getClientPrefix()
    {
        return $this->_clientPrefix;
    }

    protected function getAllowedProps()
    {
        return $this->allowedProps;
    }

    protected function getAllowedPropPrefix($prop)
    {
        return array_search($prop, $this->getAllowedProps());
    }

    /**
     * Set the value of _clientPrefix
     *
     * @return  self
     */ 
    protected function setClientPrefix($clientPrefix)
    {
        $this->_clientPrefix = $clientPrefix;

        return $this;
    }

    /**
     * Get the value of _clientMetaAttribute
     */ 
    protected function getClientMetaAttributeName()
    {
        return $this->_clientMetaAttributeName;
    }

    /**
     * Get the value of _clientMetaAttributeContent
     *
     * @return  self
     */ 
    protected function getClientMetaAttributeContent()
    {
        return $this->_clientMetaAttributeContent;
    }

    /**
     * Undocumented function
     *
     * @param string $prop
     * 
     * @return void
     */
    protected function turnClientMetaAttributeValue($prop)
    {
        return $this->getAllowedPropPrefix($prop) . $prop;
    }
}