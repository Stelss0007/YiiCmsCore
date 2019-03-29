<?php

namespace Stelssoft\YiiCmsCore;

use yii\web\Controller;

class CmsController extends Controller
{
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
