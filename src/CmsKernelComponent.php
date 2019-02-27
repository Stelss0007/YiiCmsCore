<?php
namespace Stelssoft\YiiCmsCore;

use Yii;
use yii\base\BaseObject;
use yii\base\Theme;
use app\modules\theme\models\Theme as CmsTheme;

class CmsKernelComponent extends BaseObject
{

    public function init()
    {
        parent::init();

        $this->setCmsRouteRules();
        $this->setCmsCurrentTheme();
        $this->selLocale();
        $this->registerTranslations();

        //Динамическое добавление модулей (подтягивать с базы установленые модули)
        Yii::$app->modules = array_merge(Yii::$app->modules, [
            'theme' => [
                'class' => 'app\modules\theme\Module',
            ],
            'admin' => [
                'class' => 'app\modules\admin\Module',
            ],
            'user' => [
                'class' => 'app\modules\user\Module',
            ],
        ]);
    }

    /**
     * Set current theme from DataBase
     */
    private function setCmsCurrentTheme()
    {
        //Установка темы (подтягивать с базы активную тему)
        if ($this->checkIfAdminInterface()) {
            $currentThemeName = 'admin';
        } else {
            $currentActiveTheme = CmsTheme::findOne(['active' => 1]);
            $currentThemeName = 'bydiwell';//$currentActiveTheme->name;
        }

        Yii::$app->getView()->theme = new Theme([
            'basePath' => '@app/themes/' . $currentThemeName,
            'baseUrl' => '@web/themes/' . $currentThemeName,
            'pathMap' => [
                '@app/views' => '@app/themes/' . $currentThemeName,
                '@app/modules' => '@app/themes/' . $currentThemeName . '/modules',
            ],
        ]);
    }

    private function setCmsRouteRules()
    {
        Yii::$app->getUrlManager()->addRules([
            ['class' => CmsUrlRule::class],

            [
                'pattern' => '<action>',
                'route' => 'main/default/<action>',
                'defaults' => [
                    'action' => 'index',
                ],
            ],
            [
                'pattern' => 'admin',
                'route' => 'admin/admin/index',
                'defaults' => [
                    'action' => 'index',
                    'isAdminInterface' => true,
                ],
            ],
            [
                'pattern' => 'admin/<module>/<action>',
                'route' => '<module>/admin/<action>',
                'defaults' => [
                    'action' => 'index',
                    'isAdminInterface' => true,
                ],
            ],
            [
                'pattern' => '<module>/<action>',
                'route' => '<module>/default/<action>',
                'defaults' => [
                    'action' => 'index',
                ],
            ],
        ]);
    }

    private function selLocale()
    {
        Yii::$app->language = 'ru-RU';
        Yii::$app->sourceLanguage = 'en-US';
    }

    private function checkIfAdminInterface()
    {
        $pathInfo = Yii::$app->getRequest()->getPathInfo();
        $pathInfoParts = explode('/', $pathInfo);

        return (isset($pathInfoParts[0]) && $pathInfoParts[0] === 'admin');
    }

    /**
     *
     */
    private function registerTranslations()
    {
        Yii::$app->i18n->translations['app'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath'       => '@app/messages',
            'fileMap'        => [
                'app' => 'app.php',
            ],
        ];
    }
}
