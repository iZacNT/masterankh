<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "lang".
 *
 * @property int $id
 * @property string $url
 * @property string $local
 * @property string $name
 * @property int $default
 * @property int $date_update
 * @property int $date_create
 */
class Lang extends ActiveRecord
{
    /**
     * Переменная, для хранения текущего объекта языка.
     * @var static
     */
    public static $current;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'local', 'name', 'date_update', 'date_create'], 'required'],
            [['default', 'date_update', 'date_create'], 'integer'],
            [['url', 'local', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'local' => 'Local',
            'name' => 'Name',
            'default' => 'Default',
            'date_update' => 'Date Update',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * Получение текущего объекта языка.
     * @return static
     */
    public static function getCurrent()
    {
        if (self::$current === null) {
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

    /**
     * Установка текущего объекта языка и локаль пользователя.
     * @param string $url
     */
    public static function setCurrent($url)
    {
        $language = self::getLangByUrl($url);
        self::$current = ($language == '') ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->local;
    }

    /**
     * Get default language object.
     * @return static
     */
    public static function getDefaultLang()
    {
        return Lang::find()->where('`default` = 1', [':default' => 1])->one();
    }

    /**
     * Get language object using letter identifier.
     * @param string $url
     * @return static|null
     */
    public static function getLangByUrl(string $url)
    {
        if ($url == '' || strlen($url) > 3) {
            $language = self::getDefaultLang();
        } else {
            // CACHING
            $language =  Lang::find()->where('url = :url', [':url' => $url])->one();
        }

        return $language ?? null;
    }
}
    