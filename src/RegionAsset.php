<?php ///[Yii2 region]

/**
 * Yii2 region widget
 *
 * @link        http://www.brainbook.cc
 * @see         https://github.com/yongtiger/yii2-region
 * @author      Tiger Yong <tigeryang.brainbook@outlook.com>
 * @copyright   Copyright (c) 2017 BrainBook.CC
 * @license     http://opensource.org/licenses/MIT
 */

namespace yongtiger\region;

use yii\web\AssetBundle;

/**
 * Class RegionAsset
 *
 * @package yongtiger\region
 */
class RegionAsset extends AssetBundle
{
    public $sourcePath = '@yongtiger/region/assets';

    public $js = [
        'region.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}