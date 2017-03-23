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

namespace yongtiger\region\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for region table, e.g. "{{%region_china}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $sort
 * @property integer $level
 */
class Region extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->getModule('region')->regionTableName;  ///[1.1.0 (CHG# tableName)]
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort', 'level'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * Resolve the full region string `province city district` or array `[province, city, district]` as array `[province id, city id, district id]`.
     * @param string|array $region
     * @return array
     */
    public static function parseRegion($region)
    {
        if (is_string($region)) {
            $region = explode(' ', $region);
        }
        list($province, $city, $district) = $region;
        return [
            self::getId($province),
            self::getId($city),
            self::getId($district)
        ];

    }

    /**
     * Resolve the given $province, $city, $district as full region string `province city district`.
     * @param $province
     * @param $city
     * @param $district
     * @return string
     */
    public static function createRegion($province, $city, $district)
    {
        return join(' ', [
            self::getName($province),
            self::getName($city),
            self::getName($district)
        ]);
    }

    /**
     * Get region id by the given region name.
     * @param string $name
     * @return integer
     */
    public static function getId($name)
    {
        return self::find()->where(['name' => $name])->select('id')->scalar();
    }

    /**
     * Get region name by the given region id.
     * @param integer $id
     * @return string
     */
    public static function getName($id)
    {
        return self::find()->where(['id' => $id])->select('name')->scalar();
    }

    /**
     * Get region children by the given id.
     * @param integer|null $id
     * @return array
     */
    public static function getChildren($id = null)
    {
        if (is_null($id)) {
            return [];
        }
        $children = Yii::$app->cache->get(['children', $id]);
        if ($children === false) {
            $children = self::find()->where(['parent_id' => $id])->select('name')->indexBy('id')->column();
            Yii::$app->cache->set(['children', $id], $children);
        }
        return $children;
    }
}
