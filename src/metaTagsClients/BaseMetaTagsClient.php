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
    protected $_clientPrefix = '';
    protected $_clientMetaAttributeName = 'name';
    protected $_clientMetaAttributeContent = 'content';

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
        $setter = 'set' . $prop;
        if (method_exists($this, $setter)) {
            $this->$setter($content);
            return $this;
        }

        throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $prop);
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
        $prefix = $this->getClientPrefix();
        if (substr($prop, 0, strlen($prefix)) == $prefix) {
            $prop = substr($prop, strlen($prefix));
        }
        
        //find underlines and convert to uppercase next latter after underline like: some_var to SomeVar
        $pos = strpos($prop, '_');
        if($pos) {
            $ar = explode("_", $prop);
            $prop = '';
            foreach($ar as $part){
                $prop .= ucwords($part);
            }
        }

        return $prop;
    }

    public function registerInView(View $view, $prop, $content, $setDefaultPrefix = true)
    {
        $propValue = $this->turnClientMetaAttributeValue($prop, $setDefaultPrefix);
        Yii::$app->view->registerMetaTag([
            $this->getClientMetaAttributeName() => $propValue, // like for facebook 'property' => 'og:type'
            $this->getClientMetaAttributeContent() => $content, // like for facebook 'content' => 'website'
        ], $propValue);
    }

    /**
     * ------------------
     * Indernal methods
     *-------------------
     */

    /**
     * Get the value of _clientPrefix
     */ 
    protected function getClientPrefix()
    {
        return $this->_clientPrefix;
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
     * @param [type] $prop
     * @param [type] $withDefaultPrefix
     * @return void
     */
    protected function turnClientMetaAttributeValue($prop, $withDefaultPrefix)
    {
        return $withDefaultPrefix ? $this->getClientPrefix() . $prop : $prop;
    }
}