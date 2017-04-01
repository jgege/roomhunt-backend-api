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
                    'add-person' => ['post'],
                    'add-interest' => ['post'],
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

    public function actionAddFlat()
    {
        Yii::$app->request->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $flat = new Flat();
        $flat->bedroomNo = $request->post('bedroomNo');
        $flat->longitude = $request->post('longitude');
        $flat->latitude = $request->post('latitude');
        $flat->price = $request->post('price');
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

        $request = Yii::$app->request;

        $query = Flat::find()->select([
            'id',
            'longitude',
            'latitude',
            'bedroomNo',
            'price'
        ]);

        /**
         * Price
         */
        if ($request->get('min_price')) {
            $query->andWhere(['>=', 'price', $request->get('min_price')]);
        }

        if ($request->get('max_price')) {
            $query->andWhere(['<=', 'price', $request->get('max_price')]);
        }

        /**
         * BedroomNo
         */
        if ($request->get('min_bedroom_no')) {
            $query->andWhere(['>=', 'bedroomNo', $request->get('min_bedroom_no')]);
        }

        if ($request->get('max_bedroom_no')) {
            $query->andWhere(['<=', 'bedroomNo', $request->get('max_bedroom_no')]);
        }

        /**
         * Distance calc
         */
        // todo

        return [
            'results' => $query
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
                'personList' => $personList,
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
}
