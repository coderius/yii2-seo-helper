<?php
//SeoHelperTest
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

class SeoHelperTest extends \tests\TestCase
{
  
   /**
   * @inheritdoc
   */
  public static function setUpBeforeClass()
  {
      parent::setUpBeforeClass();
      
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

}