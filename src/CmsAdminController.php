<?php

namespace Stelssoft\YiiCmsCore;

use Yii;
use yii\base\ViewNotFoundException;

class CmsAdminController extends CmsController
{
    /**
     * @return string
     */
    public function actionConfiguration()
    {
        /** @var array $config */
        $config = Yii::$app->controller->module->getConfig();

        $model = new CmsActiveForm();

        foreach($config as $key => $value) {
            $model->setField($key, $value);
        }


        try {

            return $this->render('configuration', [
                'module' => Yii::$app->controller->module,
                'config' => $config,
                'model' => $model,
            ]);
        }
        catch (ViewNotFoundException $e) {
            $currentViewPath = '@cms/views/';

            return $this->render($currentViewPath . 'configuration.php', [
                'module' => Yii::$app->controller->module,
                'config' => $config,
                'model' => $model,
            ]);
        }

    }

    /**
     * @return \yii\web\Response
     */
    public function actionSaveConfiguration()
    {
        $request = Yii::$app->request;
        $module = Yii::$app->controller->module->id;

        $params = $request->post('CmsActiveForm');

        CmsConfiguration::saveConfiguration($module, $params);
        Yii::$app->session->setFlash('success', Yii::$app->controller->module->t('Changes saved successfully'));

        return $this->redirect(Yii::$app->request->referrer);
    }
}
