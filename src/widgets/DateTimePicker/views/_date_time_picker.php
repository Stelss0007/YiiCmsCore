<?php

use yii\helpers\Html;
?>
<div class="form-group">
    <div class='input-group date' id='datetimepicker1 <?php echo $containerID; ?>'>
        <input type='text' class="form-control" />
        <?php echo Html::activeTextInput($model, $attribute, $options); ?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<?php $this->registerJs("$('#$containerID').datetimepicker();"); ?>
