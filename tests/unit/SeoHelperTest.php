<?php
//UploadFileBehavior
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

class SeoHelperTest extends \tests\TestCase
{
  
   /**
   * @inheritdoc
   */
  public static function setUpBeforeClass()
  {
      parent::setUpBeforeClass();

      //
  }

  
  public function testFirst()
  {
      $this->assertTrue(true);
  }

  public function testGetSeoHelper()
  {
    $seo = Instance::ensure('seo', SeoHelper::class);
    $this->assertInstanceOf(SeoHelper::class, $seo);
  }

  /**
  * @dataProvider metaTagsClientsProvider
  */
  public function testGetFacebookMetaTagsClient($id, $className)
  {
    $seo = Instance::ensure('seo', SeoHelper::class);
    $fb = $seo->getMetaTagsClient($id);
    
    $this->assertInstanceOf($className, $fb);
  }

  public function metaTagsClientsProvider()
  {
      return [
          ['facebook', Facebook::class],
      ];
  }

  public function testSetSeoMetaTagsFacebookInPage()
  {
    // $this->markTestSkipped('must be revisited.');
    $seo = Instance::ensure('seo', SeoHelper::class);
    $view = \Yii::$app->getView();
    $metaData = [
        'og:title' => 'meta title',
        'og:description' => 'meta desc',
        'og:type' => 'site',
        'og:url' => 'canonical url',
    ];

    $fb = $seo->getMetaTagsClient('facebook');
    $fb->addMetaTags($metaData);

    $this->assertEquals($fb->title, 'meta title');
    $this->assertEquals($fb->description, 'meta desc');
    $this->assertEquals($fb->type, 'site');
    $this->assertEquals($fb->url, 'canonical url');
  }

//   public function testRegisterSeoMetaTagsInView()
//   {
//     $seo = Instance::ensure('seo', SeoHelper::class);
//     $view = \Yii::$app->getView();
//     $metaData = [
//         'metaTitle' => 'meta title',
//         'metaDesc' => 'meta desc',
//         'metaKeywords' => 'meta keywords',
//         'url' => 'canonical url',
//     ];

//     $seo->getMetaTagsClient('facebook')
//         ->addMetaTags($metaData)
//         ->registerInView($view);

//     $expected = file_get_contents(__DIR__ . '/_data/test-counter-html.bin');  
//     $out = $view->render('index', $params = [], $context = null);    
//     $this->assertEqualsWithoutLE($expected, $out);
//   }

}