<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $module::t(ucfirst($module->id) . 's');
$this->params['breadcrumbs'][] = ['label' => $module::t(ucfirst($module->id) . 's'), 'url' => ['index']];
$this->params['breadcrumbs'][] = \Yii::t('app', 'Configuration');

$form = ActiveForm::begin(['action' => ['save-configuration']]);
?>

<div class="x_panel">
    <div class="x_title">
        <h3>
            <?php echo \Yii::t('app', 'Configuration'); ?>
        </h3>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="">
            <div class="form">
                <?php foreach ($config as $key => $value): ?>
                    <?php echo $form->field($model, $key); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>


<?php ActiveForm::end(); ?>
