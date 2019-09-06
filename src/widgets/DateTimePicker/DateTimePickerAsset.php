<?php
namespace Stelssoft\YiiCmsCore\widgets\DateTimePicker;

use yii\web\AssetBundle;

class DateTimePickerAsset extends AssetBundle
{
    public $js = [
        'js/moment-with-locales.js',
        'js/bootstrap-datetimepicker.js',
    ];

    public $css = [
        'css/bootstrap-datetimepicker.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }
}
