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
     * @return string
     */
    public static function getTranlateCategory()
    {
        return 'modules/' . self::getModuleName();
    }

    /**
     *
     */
    public static function registerTranslations()
    {
        $translateCategory = self::getTranlateCategory();

        if (isset(Yii::$app->i18n->translations[$translateCategory])) {
            return;
        }

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

        if (Yii::t($translateCategory, $message, $params, $language) !== $message) {

            return Yii::t($translateCategory, $message, $params, $language);
        }

        return Yii::t('app', $message, $params, $language);
    }

    /**
     * @return string
     */
    public static function getModuleName()
    {
        $namespacePathArray = explode('\\', static::class);

        return $namespacePathArray[count($namespacePathArray) - 2];
    }

    /**
     * @return array
     */
    public function getConfigFile()
    {
        $modulePath = dirname((new \ReflectionClass(static::class))->getFileName());
        $configSrc = $modulePath . '/config.php';
        if (file_exists($configSrc)) {
            return require $configSrc;
        }

        return [];
    }

    /**
     * @param null|string $module
     * @return array
     */
    public function getConfig($module = null)
    {
        $defaultConfigData = $this->getConfigFile();

        $moduleConfig = CmsConfiguration::findOne(['module' => $module ?:$this->id]);

        if (!$moduleConfig) {
            return $defaultConfigData;
        }

        $databaseConfigData = $moduleConfig->data ? unserialize($moduleConfig->data) : [];

        foreach ($defaultConfigData as $key => $value) {
            if (isset($databaseConfigData[$key])) {
                $defaultConfigData[$key] = $databaseConfigData[$key];
            }
        }

        return $defaultConfigData;
    }
}
