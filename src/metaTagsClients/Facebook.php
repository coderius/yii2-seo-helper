<?php 

namespace coderius\yii2SeoHelper\metaTagsClients;

use Yii;
use yii\base\Component;


class Facebook extends BaseMetaTagsClient implements MetaTagsClientInterface
{
    
    const PREF_OG = 'og:';
    const PREF_FB = 'fb:';
    
    /**
     * -------------------
     * Allowed props names
     *--------------------
     * @see https://developers.facebook.com/docs/sharing/webmasters/#markup
     */
    protected $allowedProps = [
        self::PREF_FB => 'app_id',
        self::PREF_OG => 'title',
        self::PREF_OG => 'description',
        self::PREF_OG => 'image',
        self::PREF_OG => 'type',
        self::PREF_OG => 'url',
        self::PREF_OG => 'locale'
    ];

    protected $_clientPrefix = [self::PREF_OG, self::PREF_FB];
    protected $_clientMetaAttributeName = 'property';

}