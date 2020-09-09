<?php

namespace coderius\yii2SeoHelper\metaTagsClients;

use yii\base\View;

interface MetaTagsClientInterface
{
    public function addMetaTags($metaData = []);

    public function addMetaTag($prop, $content);

    public function registerInView(View $view);
}    