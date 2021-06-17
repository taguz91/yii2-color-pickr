<?php

namespace taguz91\ColorPickr;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class InputAsset extends AssetBundle
{

  public $sourcePath = '@npm/simonwep--pickr/';
  public $css = [
    'dist/themes/nano.min.css'
  ];
  public $js = [
    'dist/pickr.min.js'
  ];
  public $depends = [
    YiiAsset::class,
  ];

  /**
   * @inheritdoc
   */
  public function init()
  {
    parent::init();
  }
}
