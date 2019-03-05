<?php

namespace Stelssoft\YiiCmsCore;

use yii\db\ActiveRecord;

class CmsConfiguration extends ActiveRecord
{
//    /**
//     * @var string
//     */
//    public $module;
//
//    /**
//     * @var string
//     */
//    private $data;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuration';
    }

    /**
     * @param string $module
     * @param array $params
     */
    public static function saveConfiguration($module, $params)
    {
        $modConfig = self::findOne(['module' => $module]);

        if(!$modConfig)
        {
            $modConfig = new self;
        }

        $modConfig->module = $module;
        $modConfig->data = serialize($params);
        $modConfig->save();
    }
}
