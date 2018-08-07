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

        //Динамическое добавление модулей (подтягивать с базы установленые модули)
        Yii::$app->modules = array_merge(Yii::$app->modules, [
            'theme' => [
                'class' => 'app\modules\theme\Module',
            ],
            'admin' => [
                'class' => 'app\modules\admin\Module',
            ],
        ]);
    }

    /**
     * Set current theme from DataBase
     */
    public function setCmsCurrentTheme()
    {
        //Установка темы (подтягивать с базы активную тему)
        if ($this->checkIfAdminInterface()) {
            $currentThemeName = 'admin';
        } else {
            $currentActiveTheme = CmsTheme::findOne(['active' => 1]);
            $currentThemeName = $currentActiveTheme->name;
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

    public function setCmsRouteRules()
    {
        Yii::$app->getUrlManager()->addRules([
            ['class' => CmsUrlRule::class],
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
        ]);
    }

    public function selLocale()
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
}
