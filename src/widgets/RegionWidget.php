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

namespace yongtiger\region\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\InputWidget;
use yongtiger\region\models\Region;
use yongtiger\region\RegionAsset;

/**
 * Class RegionWidget
 *
 * @package yongtiger\region
 */
class RegionWidget extends InputWidget
{
    public $provinceAttribute;
    public $provinceName;
    public $provinceValue;
    public $provincePrompt;

    public $cityAttribute;
    public $cityName;
    public $cityValue;
    public $cityPrompt;

    public $districtAttribute;
    public $districtName;
    public $districtValue;
    public $districtPrompt;

    public $selectClass = 'form-control';
    public $clientOptions = [];

    /**
     * @var string|array Regional collection, e.g. `北京 北京市 东城区`
     */
    public $region;

    /**
     * @var array|string the parameter to be used to generate a valid URL
     */
    public $route = ['/region/default/get-children'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->options = array_merge(['id' => 'region', 'class' => 'form-group form-inline'], $this->options);

        parent::init();

        if ($this->region) {
            list($this->provinceValue, $this->cityValue, $this->districtValue) = Region::parseRegion($this->region);
        }

        $this->clientOptions = array_merge(['defaultSelectOption' => '<option value>'. RegionWidget::t('message', '(Select ...)') . '</option>'], $this->clientOptions);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();

        if ($this->hasModel()) {

            $provinceValue = Html::getAttributeValue($this->model, $this->provinceAttribute);
            $cityValue = Html::getAttributeValue($this->model, $this->cityAttribute);

            $select = Html::activeDropDownList($this->model, $this->provinceAttribute, Region::getChildren(0), [
                'class' => $this->selectClass,
                'prompt' => $this->provincePrompt ? : RegionWidget::t('message', '(Select province ...)'),
            ]) 
            . ' ' 
            . Html::activeDropDownList($this->model, $this->cityAttribute, Region::getChildren($provinceValue), [
                'class' => $this->selectClass,
                'prompt' => $this->cityPrompt ? : RegionWidget::t('message', '(Select city ...)'),
            ]) . ' ' . Html::activeDropDownList($this->model, $this->districtAttribute, Region::getChildren($cityValue), [
                'class' => $this->selectClass,
                'prompt' => $this->districtPrompt ? : RegionWidget::t('message', '(Select district ...)'),
            ]);

        } else {

            $select = Html::dropDownList($this->provinceName, $this->provinceValue, Region::getChildren(0), [
                    'class' => $this->selectClass,
                    'prompt' => $this->provincePrompt ? : RegionWidget::t('message', '(Select province ...)'),
                ]) 
                . ' ' 
                . Html::dropDownList($this->cityName, $this->cityValue, Region::getChildren($this->provinceValue), [
                    'class' => $this->selectClass,
                    'prompt' => $this->cityPrompt ? : RegionWidget::t('message', '(Select city ...)'),
                ]) . ' ' . Html::dropDownList($this->districtName, $this->districtValue, Region::getChildren($this->cityValue), [
                    'class' => $this->selectClass,
                    'prompt' => $this->districtPrompt ? : RegionWidget::t('message', '(Select district ...)'),
                ]);

        }

        return Html::tag('div', $select, $this->options);
    }

    /**
     * Registers necessary JavaScript.
     *
     * @return yii\web\AssetBundle the registered asset bundle instance
     */
    public function registerClientScript()
    {
        RegionAsset::register($this->view);
        
        $this->clientOptions['url'] = Url::to($this->route);
        $clientOptions = Json::htmlEncode($this->clientOptions);
        $this->view->registerJs("$('#{$this->options['id']} select').getRegion($clientOptions)");
    }

    /**
     * Registers the translation files.
     */
    public static function registerTranslations()
    {
        ///[i18n]
        ///if no setup the component i18n, use setup in this module.
        if (!isset(Yii::$app->i18n->translations['extensions/yongtiger/yii2-region/*']) && !isset(Yii::$app->i18n->translations['extensions/yongtiger/yii2-region'])) {
            Yii::$app->i18n->translations['extensions/yongtiger/yii2-region/*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@vendor/yongtiger/yii2-region/src/messages',    ///default base path
                'fileMap' => [
                    'extensions/yongtiger/yii2-region/message' => 'message.php',  ///category in Module::t() is message
                ],
            ];
        }
    }

    /**
     * Translates a message. This is just a wrapper of Yii::t().
     *
     * @see http://www.yiiframework.com/doc-2.0/yii-baseyii.html#t()-detail
     *
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        static::registerTranslations();
        return Yii::t('extensions/yongtiger/yii2-region/' . $category, $message, $params, $language);
    }
}