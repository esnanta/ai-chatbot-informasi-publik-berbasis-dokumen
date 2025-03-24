<?php

namespace app\controllers;


use app\models\QaLog;
use app\models\QaLogSearch;
use app\models\Suggestion;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use yii\httpclient\Client;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'upvote' => ['post'],
                    'downvote' => ['post']
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        $model = new QaLog();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {

            // Cek apakah pertanyaan sudah ada di database
            $existingQaLog = QaLog::find()->where(['question' => $model->question])->one();

            if ($existingQaLog) {
                $answer = $existingQaLog->answer;
                $qaLog = $existingQaLog; // Simpan objek agar ID bisa dikembalikan
            } else {
                // Jika belum ada, panggil API untuk mendapatkan jawaban
                $answer = $this->askFastAPI($model->question);

                if ($answer) {
                    $qaLog = new QaLog();
                    $qaLog->question = $model->question;
                    $qaLog->answer = $answer;

                    if ($qaLog->save()) {
                        Yii::debug("Jawaban baru disimpan dengan ID: " . $qaLog->id, __METHOD__);
                    } else {
                        Yii::debug("Gagal menyimpan jawaban baru.", __METHOD__);
                    }
                }
            }

            // Format respons JSON agar ID bisa digunakan untuk upvote/downvote
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'id' => $qaLog->id,  // Kirim ID jawaban dari database
                'answer' => $answer,
                'upvote' => $qaLog->upvote ?? 0,
                'downvote' => $qaLog->downvote ?? 0,
            ];
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    private function askFastAPI(string $question): string
    {
        $api_url = 'http://127.0.0.1:8000/ask';
        $client = new Client();

        try {
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl($api_url)
                ->addHeaders(['content-type' => 'application/json'])
                ->setContent(json_encode(['question' => $question]))
                ->send();

            if ($response->isOk) {
                return $response->getData()['answer'] ?? 'Tidak ada jawaban.';
            }
        } catch (\Exception $e) {
            Yii::error('FastAPI request failed: ' . $e->getMessage());
        }
        return 'Terjadi kesalahan saat mengambil jawaban.';
    }

    public function actionUpvote()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        if ($id) {
            $qaLog = QaLog::findOne($id);
            if ($qaLog) {
                $qaLog->upvote += 1;
                if ($qaLog->save()) {
                    return ['success' => true, 'upvote' => $qaLog->upvote];
                }
            }
        }
        return ['success' => false];
    }

    public function actionDownvote()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        if ($id) {
            $qaLog = QaLog::findOne($id);
            if ($qaLog) {
                $qaLog->downvote += 1;
                if ($qaLog->save()) {
                    return ['success' => true, 'downvote' => $qaLog->downvote];
                }
            }
        }
        return ['success' => false];
    }

    public function actionLog()
    {
        $searchModel = new QaLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('log', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSuggestion($query = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($query) {
            $suggestions = Suggestion::find()
                ->where(['like', 'question', $query])
                ->limit(5)
                ->all();

            return array_map(function ($suggestion) {
                return [
                    'id' => $suggestion->id,
                    'question' => $suggestion->question,
                ];
            }, $suggestions);
        }

        return [];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
