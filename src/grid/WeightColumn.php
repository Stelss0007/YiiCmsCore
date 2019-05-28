<?php
namespace Stelssoft\YiiCmsCore\grid;

use Yii;
use yii\grid\ActionColumn as BaseActionColumn;
use yii\helpers\Html;

class WeightColumn  extends BaseActionColumn
{
    public $template = '{up} {down}';

    public $contentOptions = [
        'style'=>'width: 90px; text-align: center;'
    ];

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('up', 'arrow-up');
        $this->initDefaultButton('down', 'arrow-down');
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

                $firstModel = $this->grid->dataProvider->getModels()[0];
                $lastModel = $this->grid->dataProvider->getModels()[$this->grid->dataProvider->getTotalCount() - 1];

                switch ($name) {
                    case 'up':
                        if ($firstModel === $model) {
                            return;
                        }

                        $title = Yii::t('yii', 'Up');
                        break;
                    case 'down':
                        if ($lastModel === $model) {
                            return;
                        }

                        $title = Yii::t('yii', 'Down');
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
