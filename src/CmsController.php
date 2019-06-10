<?php

namespace Stelssoft\YiiCmsCore;

use Yii;
use yii\web\Controller;

class CmsController extends Controller
{


    public function __construct($id, $module, $config = [])
    {
        $this->setLayout('main');
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $layoutName
     */
    protected function setLayout($layoutName)
    {
        $layoutName = rtrim($layoutName, '.twig');

        $layout = sprintf('@app/themes/%s/layouts/%s.twig', Yii::$app->params['current_theme'], $layoutName);

        if (file_exists(Yii::getAlias($layout))) {
            $this->layout = $layout;

            return;
        }

        $this->layout = sprintf('@app/themes/%s/layouts/%s', Yii::$app->params['current_theme'], $layoutName);
    }

    public function getObjectName()
    {
        $objectName =  $this->module->id . '::' . $this->id . '::' . $this->action->id;

        if ($this->actionParams) {
            foreach ($this->actionParams as $key => $value) {
                $objectName .= '::' . $key . '::' . $value;
            }
        }

        return $objectName;
    }

    protected function getAccess()
    {

    }
}
