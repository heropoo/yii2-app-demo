<?php
/**
 * Date: 2019-11-08
 * Time: 11:33
 */

namespace backend\controllers;


use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class Test1Controller extends Controller
{
    public function actionIndex()
    {
        return 'test1 index';
    }

    public function actionIndex2()
    {
        return 'test1 index2';
    }
}