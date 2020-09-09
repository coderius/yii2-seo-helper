<?php
//MetaTasgClient
namespace tests\unit;

use Yii;
use yii\base\InvalidParamException;
use tests\data\model;
use tests\data\model\Article;
use yii\helpers\FileHelper;
use yii\base\InvalidConfigException;
use yii\base\InvalidCallException;
use Mockery;
use coderius\yii2SeoHelper\SeoHelper;
use coderius\yii2SeoHelper\metaTagsClients\Facebook;
use yii\di\Instance;
use yii\di\Container;

class MetaTasgClientTest extends \tests\TestCase
{
  
   /**
   * @inheritdoc
   */
  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();
    
    $container = new \yii\di\Container;
    $container->set('seo2', [
        'class' => 'coderius\yii2SeoHelper\SeoHelper',
        'metaTagsClients' => [
            'facebook' => [
                'class' => 'coderius\yii2SeoHelper\metaTagsClients\Facebook'
            ]   
        ]
    ]);  

    
  }

  public function testAddMetaTag()
  {
    $seo = Instance::ensure('seo', SeoHelper::class);
    $fb = $seo->getMetaTagsClient('facebook')->addMetaTag('og:title', 'meta title');
    $this->assertEquals($fb->getProp('og:title'), 'meta title');
  }

  public function testAddMetaTags()
  {
    // $this->markTestSkipped('must be revisited.');
    $seo = Instance::ensure('seo', SeoHelper::class);
    $view = \Yii::$app->getView();
    $metaData = [
        'og:title' => 'meta title',
        'og:description' => 'meta desc',
        'og:type' => 'site',
        'og:url' => 'canonical url',
        'fb:app_id' => 1234
    ];

    $fb = $seo->getMetaTagsClient('facebook')->addMetaTags($metaData);

    $this->assertEquals($fb->getProp('og:title'), 'meta title');
    $this->assertEquals($fb->getProp('og:description'), 'meta desc');
    $this->assertEquals($fb->getProp('og:type'), 'site');
    $this->assertEquals($fb->getProp('og:url'), 'canonical url');
    $this->assertEquals($fb->getProp('fb:app_id'), 1234);
  }

  public function testFilterAddMetaTag()
  {
    $seo = Instance::ensure('seo', SeoHelper::class);
    $fb = $seo->getMetaTagsClient('facebook')->filterAddMetaTag('title', 'meta title');
    $this->assertEquals($fb->getProp('og:title'), 'meta title');
  }
  
  public function testFilterAddMetaTagsToClient()
  {
    // $this->markTestSkipped('must be revisited.');
    $seo = Instance::ensure('seo', SeoHelper::class);
    $view = \Yii::$app->getView();
    $metaData = [
        'title' => 'meta title',
        'description' => 'meta desc',
        'type' => 'site',
        'url' => 'canonical url',
        'app_id' => 1234
    ];

    $fb = $seo->getMetaTagsClient('facebook')->filterAddMetaTags($metaData);

    $this->assertEquals($fb->getProp('og:title'), 'meta title');
    $this->assertEquals($fb->getProp('og:description'), 'meta desc');
    $this->assertEquals($fb->getProp('og:type'), 'site');
    $this->assertEquals($fb->getProp('og:url'), 'canonical url');
    $this->assertEquals($fb->getProp('fb:app_id'), 1234);
  }

  public function testFilterAddMetaTagsToAllClients()
  {
    // $this->markTestSkipped('must be revisited.');
    $seo = Instance::ensure('seo', SeoHelper::class);
    $view = \Yii::$app->getView();
    $metaData = [
        'title' => 'meta title',
        'description' => 'meta desc',
        'type' => 'site',
        'url' => 'canonical url',
        'app_id' => 1234
    ];

    $seo->getMetaTagsClients()->filterAddMetaTags($metaData);
    $fb = $seo->getMetaTagsClient('facebook');

    $this->assertEquals($fb->getProp('og:title'), 'meta title');
    $this->assertEquals($fb->getProp('og:description'), 'meta desc');
    $this->assertEquals($fb->getProp('og:type'), 'site');
    $this->assertEquals($fb->getProp('og:url'), 'canonical url');
    $this->assertEquals($fb->getProp('fb:app_id'), 1234);
  }

  public function testGetSeoMetaTagHtml()
  {
    $seo = Instance::ensure('seo', SeoHelper::class);
    $fb = $seo->getMetaTagsClient('facebook')->addMetaTag('og:title', 'meta title');
    $this->assertEquals($fb->getProp('og:title')->html(), "<meta property='og:title' content='meta title'>");
  }

  public function testGetSeoMetaTagsGetProps()
  {
    $seo = Instance::ensure('seo', SeoHelper::class);
    $view = \Yii::$app->getView();
    $metaData = [
        'title' => 'meta title',
        'description' => 'meta desc',
        'type' => 'site',
        'url' => 'canonical url',
        'app_id' => 1234
    ];

    $equals = [
        'og:title' => 'meta title',
        'og:description' => 'meta desc',
        'og:type' => 'site',
        'og:url' => 'canonical url',
        'fb:app_id' => 1234
    ];

    $fb = $seo->getMetaTagsClient('facebook')->filterAddMetaTags($metaData);

    $this->assertEquals(json_encode($fb->getProps()), json_encode($equals));
    
  }

  public function testRegisterSeoMetaTagInView()
  {
    $seo = Instance::ensure('seo', SeoHelper::class);
    $view = \Yii::$app->getView();
    $fb = $seo->getMetaTagsClient('facebook');
    $fbTag = $fb->addMetaTag('og:title', 'meta title');
    $fb->registerInView($fbTag, $view);
    $this->assertEquals($view->metaTags['og:title'], $fb->getProp('og:title'));
  }

  public function testRegisterSeoMetaTagsInView()
  {
    $this->markTestSkipped('must be revisited.');
    $seo = Instance::ensure('seo', SeoHelper::class);
    $view = \Yii::$app->getView();
    $metaData = [
        'og:title' => 'meta title',
        'og:description' => 'meta desc',
        'og:type' => 'site',
        'og:url' => 'canonical url',
        'fb:app_id' => 1234
    ];

    $fb = $seo->getMetaTagsClient('facebook')->addMetaTags($metaData);
    $fb->registerInView($view);
    $this->assertEquals($view->metaTags['og:title'], 'meta title');
  }

}