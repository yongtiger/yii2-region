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

namespace yongtiger\region\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yongtiger\region\models\Region;

/**
 * Default Controller
 *
 * @package yongtiger\region\controllers
 */
class DefaultController extends Controller
{
    /**
     * Get Children.
     *
     * @param string $id
     * @return array
     */
    public function actionGetChildren($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_numeric($id)) {
            $id = null;
        }
        return Region::getChildren($id);
    }
}
