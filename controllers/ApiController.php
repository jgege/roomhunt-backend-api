<?php namespace app\controllers;

use yii\web\Controller;

class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'Hello' => 'MLH Prime!',
        ];
    }

    public function actionFlatList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'results' => $this->getDummyFlatData(),
        ];
    }

    public function actionPersonInterestedInList($flat_id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $flatData = $this->getDummyFlatData();

        $found = false;
        foreach ($flatData as $flat) {
            if ($flat['id'] == $flat_id) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new \yii\web\NotFoundHttpException;
        }

        return [
            [
                'personList' => $this->getDummyPersonInterestedInData($flat_id),
                'price' => $flat['price'],
                'bedroomNo' => $flat['bedroomNo'],
            ],
        ];
    }

    private function getDummyFlatData()
    {
        return  [
            [
                'id' => 1,
                'longitude' => '50.0000',
                'latitude' => '55.0000',
                'bedroomNo' => 3,
                'price' => 1000,
            ],
            [
                'id' => 2,
                'longitude' => '40.0000',
                'latitude' => '45.0000',
                'bedroomNo' => 1,
                'price' => 700,
            ],
            [
                'id' => 3,
                'longitude' => '90.0000',
                'latitude' => '39.0000',
                'bedroomNo' => 6,
                'price' => 5000,
            ],
        ];
    }

    private function getDummyPersonInterestedInData($flatId)
    {
        $data = [
            1 => [
                [
                    'name' => 'TestName 1',
                    'picture' => 'itssomething.jpg',
                    'url' => 'http://facebook.com',
                ],
                [
                    'name' => 'TestName XY',
                    'picture' => 'itssomething.jpg',
                    'url' => 'http://facebook.com',
                ],
                [
                    'name' => 'TestName 657',
                    'picture' => 'itssomething.jpg',
                    'url' => 'http://facebook.com',
                ],
            ],
            2 => [
                [
                    'name' => 'TestName 69',
                    'picture' => 'itssomething.jpg',
                    'url' => 'http://facebook.com',
                ],
                [
                    'name' => 'TestName 1',
                    'picture' => 'itssomething.jpg',
                    'url' => 'http://facebook.com',
                ],
            ],
            3 => [
                [
                    'name' => 'TestName 404',
                    'picture' => 'itssomething.jpg',
                    'url' => 'http://facebook.com',
                ],
                [
                    'name' => 'TestName XY',
                    'picture' => 'itssomething.jpg',
                    'url' => 'http://facebook.com',
                ],
            ],
        ];

        if (isset($data[$flatId])) {
            return $data[$flatId];
        }

        return null;
    }
}
