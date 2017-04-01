<?php namespace app\controllers;

use app\models\Flat;
use app\models\Person;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;
use app\models\PersonInterestedInFlat;

class ApiController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $this->enableCsrfValidation = false;

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add-flat' => ['post'],
                ],
            ],
        ];
    }

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
        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'Hello' => 'MLH Prime!',
        ];
    }

    public function actionAddFlat()
    {
        Yii::$app->request->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $flat = new Flat();
        $flat->bedroomNo = $request->post('bedroomNo');
        $flat->longitude = $request->post('bedroomNo');
        $flat->latitude = $request->post('bedroomNo');
        $flat->price = $request->post('bedroomNo');
        if ($flat->validate()) {
            $flat->save();
            return [
                'success' => true,
                'error' => [],
            ];
        }

        return [
            'success' => true,
            'error' => $flat->getErrors(),
        ];
    }

    public function actionAddPerson()
    {
        Yii::$app->request->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $person = new Person();
        $person->name = $request->post('name');
        $person->picture = $request->post('picture');
        $person->url = $request->post('url');

        if ($person->validate()) {
            return [
                'success' => $person->save(),
                'error' => [],
            ];
        }

        return [
            'success' => true,
            'error' => $person->getErrors(),
        ];
    }

    public function actionFlatList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'results' => Flat::find()->select([
                'id',
                'longitude',
                'latitude',
                'bedroomNo',
                'price'
            ])
            ->asArray()
            ->all(),
        ];
    }

    public function actionPersonInterestedInList($flat_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $flat = Flat::find()->where(['id' => $flat_id])->one();

        if ($flat == null) {
            throw new \yii\web\NotFoundHttpException;
        }

        $personList = [];
        foreach ($flat->persons as $person) {
            $personList[] = [
                'name' => $person->name,
                'picture' => $person->picture,
                'url' => $person->url,
            ];
        }

        return [
            [
                'personList' => $this->getDummyPersonInterestedInData($flat_id),
                'price' => $flat['price'],
                'bedroomNo' => $flat['bedroomNo'],
            ],
        ];
    }

    public function actionAddInterest()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $flat_id = $request->post('flat_id');
        $person_id = $request->post('person_id');

        if ($flat_id === null || $person_id === null) {
            throw new \yii\web\NotFoundHttpException;
        }

        $piif = PersonInterestedInFlat::find()
            ->where(['flat_id' => $flat_id, 'person_id' => $person_id])
            ->one();

        // Delete connection
        if ($piif && $piif->deleted_at != null) {
            $piif->deleted_at = null;
            return [
                'success' => $piif->save(),
                'error' => null,
            ];
        } else if($piif) {
            return [
                'success' => false,
                'error' => 'Exists already.',
            ];
        }

        $piif = new PersonInterestedInFlat();
        $piif->person_id = $person_id;
        $piif->flat_id = $flat_id;

        return [
            'success' => $piif->save(),
            'error' => $piif->getErrors(),
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
