<?php

namespace Stelssoft\YiiCmsCore;

use yii\db\ActiveRecord;

class CmsActiveRecord extends ActiveRecord
{
    public function actvate()
    {
        if ($this->hasAttribute('active')) {
            $this->active = 1;
            $this->save(false);
        }
    }

    public function deactivate()
    {
        if ($this->hasAttribute('active')) {
            $this->active = 0;
            $this->save(false);
        }
    }
}
