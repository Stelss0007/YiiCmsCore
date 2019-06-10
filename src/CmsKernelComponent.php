<?php
namespace Stelssoft\YiiCmsCore;

use app\modules\install\Module as InstallModule;
use Yii;
use yii\base\BaseObject;
use yii\base\Theme;

class CmsKernelComponent extends BaseObject
{

    public function init()
    {
        parent::init();

        Yii::setAlias('@cms', '@vendor/stelssoft/yii-cms-core/src');

        $this->setCmsRouteRules();
        $this->setCmsCurrentTheme();
        $this->selLocale();
        $this->registerTranslations();

        //Динамическое добавление модулей (подтягивать с базы установленые модули)
        Yii::$app->modules = array_merge(Yii::$app->modules, [
            'install' => [
                'class' => InstallModule::class,
            ],
        ]);

        Yii::$app->modules = array_merge(Yii::$app->modules, $this->getActiveModules());
    }

    private function getActiveModules()
    {
        return [
            'main' => [
                'class' => 'app\modules\main\Module',
            ],
            'group' => [
                'class' => 'app\modules\group\Module',
            ],
            'permission' => [
                'class' => 'app\modules\permission\Module',
            ],
            'theme' => [
                'class' => 'app\modules\theme\Module',
            ],
            'user' => [
                'class' => 'app\modules\user\Module',
            ],
            'module' => [
                'class' => 'app\modules\module\Module',
            ],
//            'admin' => [
//                'class' => 'app\modules\admin\Module',
//            ],

        ];
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
            //$currentActiveTheme = CmsTheme::findOne(['active' => 1]);
            //$currentThemeName = $currentActiveTheme->name;
            $currentThemeName = 'bydiwell';
        }

        Yii::$app->getView()->theme = new Theme([
            'basePath' => '@app/themes/' . $currentThemeName,
            'baseUrl' => '@web/themes/' . $currentThemeName,
            'pathMap' => [
                '@app/views' => '@app/themes/' . $currentThemeName,
                '@app/modules' => '@app/themes/' . $currentThemeName . '/modules',
            ],
        ]);

        Yii::$app->params['current_theme'] = $currentThemeName;
    }

    private function setCmsRouteRules()
    {
        $this->addModulesRoutes();

        Yii::$app->getUrlManager()->addRules([
            ['class' => CmsUrlRule::class],

            [
                'pattern' => 'admin',
                'route' => 'main/admin/index',
            ],

            [
                'pattern' => 'install',
                'route' => 'install/default/index',
                'defaults' => [
                    'action' => 'index',
                ],
            ],
            [
                'pattern' => '<action>',
                'route' => 'main/default/<action>',
                'defaults' => [
                    'action' => 'index',
                ],
            ],


        ]);
    }

    private function addModulesRoutes()
    {
        $modules = array_keys($this->getActiveModules());

        foreach ($modules as $module) {

            // Frontend module routes
            $routesFile = Yii::getAlias(sprintf('@app/modules/%s/routes/default.php', $module));
            if (file_exists($routesFile)) {
                $routes = require $routesFile;

                foreach($routes as $key => $route) {
                    if ($route['pattern']) {
                        $route['pattern'] = $module . '/' . $route['pattern'];

                        $routes[$key] = $route;
                    }
                }

                Yii::$app->getUrlManager()->addRules($routes);
            }

            // Backend (Admin) module routes
            $routesFile = Yii::getAlias(sprintf('@app/modules/%s/routes/admin.php', $module));
            if (file_exists($routesFile)) {
                $routes = require $routesFile;

                foreach($routes as $key => $route) {
                    if ($route['pattern']) {
                        $route['pattern'] = 'admin/' . $module . '/' . $route['pattern'];

                        $routes[$key] = $route;
                    }
                }

                Yii::$app->getUrlManager()->addRules($routes);
            }
        }
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

        return (isset($pathInfoParts[0]) && $pathInfoParts[0] === 'admin' || $pathInfoParts[0] === 'install');
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
