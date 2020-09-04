<?php

namespace tests\data\model;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use coderius\yii2UploadFileBehavior\UploadFileBehavior;
use yii\imagine\Image;
use Imagine\Image\Point;
use Imagine\Image\Box;
/**
 * This is the model class for table "portfoleo_photo".
 *
 * @property int $id
 * @property string $meta_title
 * @property string $meta_desc
 * @property string $meta_keys
 * @property string $header
 * @property string $text
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meta_title', 'meta_desc', 'meta_keys', 'header', 'text'], 'required'],
            [['img_src', 'file'], 'safe'],
        ];
    }

}
