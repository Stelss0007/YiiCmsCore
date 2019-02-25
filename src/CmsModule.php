<?php

namespace Stelssoft\YiiCmsCore;

use Yii;
use yii\base\Module;

class CmsModule extends Module
{
    /**
     * @var string controller name
     */
    public $defaultControllerName = 'DefaultController';

    /**
     *
     */
    public function init()
    {
        parent::init();
        self::registerTranslations();
    }

    /**
     *
     */
    public static function registerTranslations()
    {
        $translateCategory = 'modules/' . self::getModuleName();

        Yii::$app->i18n->translations[$translateCategory] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath'       => '@app/' . $translateCategory . '/messages',
            'fileMap'        => [
                $translateCategory => 'messages.php',
            ],
        ];
    }

    /**
     * @param string $message
     * @param array $params
     * @param null|string $language
     * @return string
     */
    public static function t($message, $params = [], $language = null)
    {
        $translateCategory =  'modules/' . self::getModuleName();

        if (!isset(Yii::$app->i18n->translations[$translateCategory])) {
            self::registerTranslations();
        }

        return Yii::t($translateCategory, $message, $params, $language);
    }

    /**
     * @return string
     */
    public static function getModuleName()
    {
        $namespacePathArray = explode('\\', static::class);

        return $namespacePathArray[count($namespacePathArray) - 2];
    }
}
