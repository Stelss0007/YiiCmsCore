<?php
namespace Stelssoft\YiiCmsCore\grid;

use Yii;
use yii\grid\ActionColumn as BaseActionColumn;
use yii\helpers\Html;

class ActionColumn  extends BaseActionColumn
{
    //public $headerOptions = ['class' => 'action-column btn-group  btn-group-sm'];

    public $template = '{view} {update} {activate} {deactivate} {delete}';

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('activate', 'play');
        $this->initDefaultButton('deactivate', 'pause');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                $btnClass = 'btn-default';

                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'activate':
                        if (!$model->hasAttribute('active') || $model->active === 1) {
                            return;
                        }
                        $title = Yii::t('app', 'Activate');
                        break;
                    case 'deactivate':
                        if (!$model->hasAttribute('active') || $model->active === 0) {
                            return;
                        }

                        $title = Yii::t('app', 'Deactivate');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $btnClass = 'btn-danger';
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    'class' => 'btn btn-control ' . $btnClass,
                ], $additionalOptions, $this->buttonOptions);

                $icon = Html::tag('i', '', ['class' => 'fa fa-' . $iconName]);

                return Html::a($icon, $url, $options);
            };
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return Html::tag('div', parent::renderDataCellContent($model, $key, $index), ['class' => 'btn-group btn-group-sm']);;
    }
}
