<?php

namespace Stelssoft\YiiCmsCore;


use yii\base\Model;

class CmsActiveForm extends Model
{
    private $formFields = [];

    public function __get($name)
    {
        if (!isset($this->formFields[$name])) {
            return null;
        }
        return $this->formFields[$name];
    }

    public function __set($name, $value)
    {
        $this->setField($name, $value);
    }

    public function setField($name, $value)
    {
        $this->formFields[$name] = $value;
    }
}
