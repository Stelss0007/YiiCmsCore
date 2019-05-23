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
        $this->showMessage('Changes saved successfully');

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionActivate($id)
    {
        $this->setActveStatus($id, 1);
        $this->showMessage('Changes saved successfully');

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionDeactivate($id)
    {
        $this->setActveStatus($id, 0);
        $this->showMessage('Changes saved successfully');

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @param integer $status
     * @throws \Exception
     */
    protected function setActveStatus($id, $status)
    {
        if (!method_exists($this, 'findModel')) {
            throw new \Exception('Method "findModel" is not exists');
        }

        $model = $this->findModel($id);

        if (!$model->hasAttribute('active')) {
            throw new \Exception('Field "active" is not exists');
        }

        $model->active = $status;
        $model->save(false);
    }

    /**
     * @param string $message
     * @param string $type
     * @param null|array $keys
     */
    protected function showMessage($message, $type = 'success', $keys = null)
    {
        Yii::$app->session->setFlash($type, Yii::$app->controller->module->t($message, $keys));
    }

    protected function showSuccess($message, $keys = null)
    {
        $this->showMessage($message, 'success', $keys);
    }

    protected function showDanger($message, $keys = null)
    {
        $this->showMessage($message, 'error', $keys);
    }

    protected function showWarning($message, $keys = null)
    {
        $this->showMessage($message, 'error', $keys);
    }
}
