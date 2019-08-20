<?php


namespace frontend\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;

class ChatController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['*'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $user = \Yii::$app->getUser()->getIdentity();
        return $this->render('index', compact('user'));
    }
}