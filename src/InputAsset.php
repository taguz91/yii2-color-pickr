<?php

namespace taguz91\ColorPickr;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class InputAsset extends AssetBundle
{

  public $sourcePath = '';
  public $css = [];
  public $js = [
    'simonwep--pickr/dist/pickr.min.js'
  ];
  public $depends = [
    YiiAsset::class,
  ];

  /**
   * @inheritdoc
   */
  public function init()
  {
    $this->sourcePath = dirname(dirname(__DIR__)) . '/vendor/npm-asset';
    parent::init();
  }
}
