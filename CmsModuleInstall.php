<?php

namespace app\cms;

use yii\db\SchemaBuilderTrait;

class CmsModuleInstall
{
    use SchemaBuilderTrait;

    public $db = 'db';

    /**
     * {@inheritdoc}
     * @since 2.0.6
     */
    protected function getDb()
    {
        return $this->db;
    }

    /*
     * TODO: Доделать класс инсталяции, по аналогии с миграциями
     */
}
