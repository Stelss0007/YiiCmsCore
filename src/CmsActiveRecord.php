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

    public function weightUp()
    {
        if (!$this->hasAttribute('weight')) {
            return false;
        }

        if($this->weight >= $this->getMaxWeight()) {
            return false;
        }

        $this->weight += 1;

        $prevRecord = self::findOne(['weight' => $this->weight]);
        $prevRecord->weight -= 1;
        $prevRecord->save(false);

        $this->save(false);

        return true;
    }


    public function weightDown($condition = [])
    {
        if (!$this->hasAttribute('weight')) {
            return false;
        }

        if($this->weight < 2) {
            return false;
        }

        $this->weight -= 1;

        $prevRecord = self::findOne(['weight' => $this->weight]);
        $prevRecord->weight += 1;
        $prevRecord->save();

        $this->save();

        return true;
    }

    public function getMaxWeight()
    {
        $record = static::find()->orderBy(['weight' => SORT_DESC])->one();

        if (null === $record) {
            return 0;
        }

        return $record->weight;
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord && $this->hasAttribute('weight')) {
           $this->weight = $this->getMaxWeight() + 1;
        }

        return parent::beforeSave($insert);
    }
}
