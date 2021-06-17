<?php

namespace taguz91\ColorPickr;

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\InputWidget;

class Input extends InputWidget
{

    /** @var string - Default hexadecimal color */
    public $default = '#42445A';

    public function run()
    {
        $this->registerAssets();
        Html::addCssClass($this->options, 'form-control');
        $input = $this->getInput();
        return '<div class="color-picker"></div>'
            . "\n{$input}";
    }

    protected function getInput(): string
    {
        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        }
        return Html::activeHiddenInput($this->name, $this->value, $this->options);
    }

    public function registerAssets()
    {
        $view = $this->getView();
        InputAsset::register($view);
        $this->initJs($view);
    }

    public function getPickertName(): string
    {
        $inputId = $this->getInputId();
        return trim(str_replace(
            ['-', ' '],
            '',
            "pickr{$inputId}"
        ));
    }

    public function getInputId(): string
    {
        return $this->options['id'];
    }

    public function getCurrentValue(): string
    {
        $value = $this->hasModel() ? Html::getAttributeValue($this->model, $this->attribute) : $this->default;
        $value = empty($value) ? $this->default : $value;
        return $value;
    }

    public function initJs(View $view)
    {
        $inputId = $this->getInputId();
        $pickertName = $this->getPickertName();
        $value = $this->getCurrentValue();

        $js = <<< JS
    const $pickertName = Pickr.create({
    el: '.color-picker',
    default: '$value',
    theme: 'nano',

    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 1)',
        'rgba(156, 39, 176, 1)',
        'rgba(103, 58, 183, 1)',
        'rgba(63, 81, 181, 1)',
        'rgba(33, 150, 243, 1)',
        'rgba(3, 169, 244, 1)',
        'rgba(0, 188, 212, 1)',
        'rgba(0, 150, 136, 0.75)',
        'rgba(76, 175, 80, 0.8)',
        'rgba(139, 195, 74, 0.85)',
        'rgba(205, 220, 57, 0.9)',
        'rgba(255, 235, 59, 0.95)',
        'rgba(255, 193, 7, 1)'
    ],

    components: {
        // Main components
        preview: true,
        opacity: true,
        hue: true,
        // Input / output Options
        interaction: {
            hex: true,
            input: true,
            save: true
        }
    }
});

$pickertName.on('save', (color, instance) => {
    document.querySelector('#$inputId').value = color.toHEXA();
}).on('change', (color, source, instance) => {
    document.querySelector('#$inputId').value = color.toHEXA();
});
JS;
        $view->registerJs($js);
    }
}
