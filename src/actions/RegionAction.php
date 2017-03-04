<?php ///[yii2-region]

/**
 * Yii2 region widget
 *
 * @link        http://www.brainbook.cc
 * @see         https://github.com/yongtiger/yii2-popup-alert
 * @author      Tiger Yong <tigeryang.brainbook@outlook.com>
 * @copyright   Copyright (c) 2017 BrainBook.CC
 * @license     http://opensource.org/licenses/MIT
 */

namespace yongtiger\region\actions;

use yii\base\Action;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;

class RegionAction extends Action
{
    /**
     * @var \yii\db\ActiveRecord Region Model
     */
    public $model=null;

    public function init()
    {
        parent::init();
        if(!$this->model)throw new InvalidParamException('model不能为null');
    }

    public function run()
    {
        $parent_id=Yii::$app->request->get('parent_id');
        $modelClass=$this->model;
        if($parent_id>0){
            return Html::renderSelectOptions('district',$modelClass::getRegion($parent_id));
        }else{
            return [];
        }
    }
}