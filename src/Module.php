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

use Yii;

/**
 * Class Module
 *
 * @package yongtiger\region
 */
class Module extends \yii\base\Module
{

    ///[1.1.0 (CHG# tableName)]
    /**
     * Table name of setting
     *
     * @var string
     */
    public $regionTableName = '{{%region_china}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
