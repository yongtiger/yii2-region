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

namespace yongtiger\region\behaviors;

use yii\base\Behavior;
use yii\base\InvalidConfigException;

class RegionBehavior extends Behavior
{
    /**
     * @var string 省份字段名
     */
    public $provinceAttribute='province_id';

    /**
     * @var string 城市字段名
     */
    public $cityAttribute='city_id';

    /**
     * @var string 县字段名
     */
    public $districtAttribute='district_id';

    /**
     * @var null|\yii\db\ActiveRecord Region Model
     */
    public $modelClass=null;

    public function init()
    {
        if(!$this->modelClass)throw new InvalidConfigException('modelClass不能为空！');
    }

    public function getProvince()
    {
        $modelClass=$this->modelClass;
        return $this->owner->hasOne($modelClass::className(),['id'=>$this->provinceAttribute]);
    }

    public function getCity()
    {
        $modelClass=$this->modelClass;
        return $this->owner->hasOne($modelClass::className(),['id'=>$this->cityAttribute]);
    }

    public function getDistrict()
    {
        $modelClass=$this->modelClass;
        return $this->owner->hasOne($modelClass::className(),['id'=>$this->districtAttribute]);
    }

    /**
     * 返回完整的地区名称
     * @example 广东深圳市宝安区
     * @param bool $useDistrict 是否要返回县/区
     * @return string
     */
    public function getFullRegion($useDistrict=false)
    {
        return $this->owner->province['name'].$this->owner->city['name'].($useDistrict ? $this->owner->district['name'] : '');
    }
}
