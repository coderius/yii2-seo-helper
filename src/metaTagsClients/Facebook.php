<?php 

namespace coderius\yii2SeoHelper\metaTagsClients;

use Yii;
use yii\base\Component;


class Facebook extends BaseMetaTagsClient implements MetaTagsClientInterface
{
    private $_appId;
    private $_clientPrefix = 'og';

    /**
     * Get the value of _appId
     */ 
    public function getAppId()
    {
        return $this->_appId;
    }

    /**
     * Set the value of _appId
     *
     * @return  self
     */ 
    public function setAppId($appId)
    {
        $this->_appId = $appId;

        return $this;
    }
}