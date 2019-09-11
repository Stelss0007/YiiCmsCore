<?php

use yii\helpers\Html;
?>
<div class="form-group">
    <div class='input-group date' id='<?php echo $containerID; ?>'>
        <?php
            $options['class'] = 'form-control';
            echo Html::activeTextInput($model, $attribute, $options);
        ?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<?php $this->registerJs("$('#$containerID').datetimepicker();"); ?>
