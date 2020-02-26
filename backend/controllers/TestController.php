<?php
/**
 * Date: 2019-11-08
 * Time: 11:33
 */

namespace backend\controllers;


use yii\web\Controller;

class TestController extends Controller
{
    public $layout = 'layui';

    public function actionIndex()
    {
        //return 'test1 index';
        return $this->render('index');
    }

    public function actionIndex2()
    {
        return 'test1 index2';
    }
}