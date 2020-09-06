<?php 

namespace coderius\yii2SeoHelper;

use Yii;
use yii\base\Component;
use yii\base\InvalidArgumentException;

class SeoHelper extends Component
{
    private $_metaTagsClients = [];

    /**
     * Get the value of _metaTagsClients
     */ 
    public function getMetaTagsClients()
    {
        $metaTagsClients = [];
        foreach ($this->_metaTagsClients as $id => $client) {
            $metaTagsClients[$id] = $this->getMetaTagsClient($id);
        }

        return $metaTagsClients;
    }

    /**
     * Set the value of _metaTagsClients
     *
     * @return  self
     */ 
    public function setMetaTagsClients(array $metaTagsClients)
    {
        $this->_metaTagsClients = $metaTagsClients;
        return $this;
    }

    public function getMetaTagsClient($id)
    {
        if (!array_key_exists($id, $this->_metaTagsClients)) {
            throw new InvalidArgumentException("Unknown auth client '{$id}'.");
        }
        if (!is_object($this->_metaTagsClients[$id])) {
            $this->_metaTagsClients[$id] = $this->createMetaTagsClient($id, $this->_metaTagsClients[$id]);
        }

        return $this->_metaTagsClients[$id];
    }

    protected function createMetaTagsClient($id, $config)
    {
        $config['id'] = $id;

        return Yii::createObject($config);
    }
}