<?php

namespace coderius\yii2SeoHelper\metaTagsClients;

use yii\base\View;

interface MetaTagsClientInterface
{
    public function getMetaTitle();

    public function setMetaTitle($metaTitle);

    public function getMetaDesc();

    public function setMetaDesc($metaDesc);

    public function getMetaKeywords();

    public function setMetaKeywords($metaKeywords);

    public function getUrl();

    public function setUrl($url);

    public function addMetaTags($metaData = []);

    public function registerInView(View $view);
}    