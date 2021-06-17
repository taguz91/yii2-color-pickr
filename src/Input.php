<?php

namespace taguz91\ColorPickr;

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\InputWidget;

class Input extends InputWidget
{
    public function run()
    {
        Html::addCssClass($this->options, 'form-control');
        $input = $this->getInput();
        return '<div class="color-picker"></div>'
            . "\n{$input}";
    }

    protected function getInput()
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
    }

    public function initJs(View $view)
    {
        $inputId = $this->options['id'];
        $js = <<< JS
    const pickr = Pickr.create({
    el: '.color-picker',
    default: '#42445A',
    theme: 'nano', // or 'monolith', or 'nano'

    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 0.95)',
        'rgba(156, 39, 176, 0.9)',
        'rgba(103, 58, 183, 0.85)',
        'rgba(63, 81, 181, 0.8)',
        'rgba(33, 150, 243, 0.75)',
        'rgba(3, 169, 244, 0.7)',
        'rgba(0, 188, 212, 0.7)',
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

pickr.on('save', (color, instance) => {
    console.log('Event: "save `$inputId`"', color, instance);
}).on('change', (color, source, instance) => {
    console.log('Event: "change" `$inputId`', color, source, instance);
});
JS;
        $view->registerJs($js);
    }
}
