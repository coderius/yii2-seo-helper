<?php

namespace tests;

use Yii;
use yii\base\Action;
use yii\base\Module;
use yii\di\Container;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
/**
 * This is the base class for all yii framework unit tests.
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockWebApplication();
        $this->setupTestDbData();
    }
    /**
     * Clean up after test.
     * By default the application created with [[mockApplication]] will be destroyed.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyApplication();
    }
    /**
     * @param array $config
     * @param string $appClass
     */
    protected function mockWebApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',
            'aliases' => [
                '@bower' => '@vendor/bower',
                '@npm' => '@vendor/npm',
                '@uploadsPath' => '@tests/data/uploads',
            ],
            'components' => [
                'request' => [
                    'cookieValidationKey' => 'wefJDF8sfdsfSDefwqdxj9oq',
                    'hostInfo' => 'http://domain.com',
                    'scriptUrl' => 'index.php',
                ],
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                ],
                'seo' => [
                    'class' => 'coderius\yii2SeoHelper\SeoHelper',
                    'metaTagsClients' => [
                        'facebook' => [
                            'class' => 'coderius\yii2SeoHelper\metaTagsClients\Facebook'
                        ]   
                    ]
                ]
            ],
        ], $config));
    }
    /**
     * Mocks controller action with parameters
     *
     * @param string $controllerId
     * @param string $actionID
     * @param string $moduleID
     * @param array $params
     */
    protected function mockAction($controllerId, $actionID, $moduleID = null, $params = [])
    {
        Yii::$app->controller = $controller = new Controller($controllerId, Yii::$app);
        $controller->actionParams = $params;
        $controller->action = new Action($actionID, $controller);
        if ($moduleID !== null) {
            $controller->module = new Module($moduleID);
        }
    }
    /**
     * Removes controller
     */
    protected function removeMockedAction()
    {
        Yii::$app->controller = null;
    }
    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
        Yii::$container = new Container();
    }
    /**
     * Asserting two strings equality ignoring line endings
     *
     * @param string $expected
     * @param string $actual
     */
    public function assertEqualsWithoutLE($expected, $actual)
    {
        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }

    /**
     * Setup tables for test ActiveRecord
     */
    protected function setupTestDbData()
    {
        $db = Yii::$app->getDb();

        // Structure :

        $table = 'article';
        $columns = [
            'id' => 'pk',
            'meta_title' => 'string',
            'meta_desc' => 'string',
            'meta_keys' => 'string',
            'header' => 'string',
            'text' => 'string',
        ];
        $db->createCommand()->createTable($table, $columns)->execute();

        // Data :

        $db->createCommand()->batchInsert('article', 
        ['meta_title', 'meta_desc', 'meta_keys', 'header', 'text'],
        [
            ['meta_title-1', 'meta_desc-1', 'meta_keys-1', 'header-1', 'text-1'],
            ['meta_title-2', 'meta_desc-2', 'meta_keys-2', 'header-2', 'text-2'],
            ['meta_title-3', 'meta_desc-3', 'meta_keys-3', 'header-3', 'text-3'],
        ])->execute();

    }
}