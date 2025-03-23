<?php

namespace app\controllers;

use app\models\ChatbotForm;
use Yii;
use yii\filters\AccessControl;
use yii\httpclient\Exception;
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

    /**
     * Displays the chatbot UI and handles the question submission.
     * @return string
     * @throws Exception
     */
    public function actionIndex()
    {
        $model = new ChatbotForm();
        $model->question = "Jelaskan komponen pembinaan dan pengembangan prestasi?";
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $answer = $this->askFastAPI($model->question);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['answer' => $answer];
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
            // Explicitly JSON encode the data
            $jsonData = json_encode(['question' => $question]);

            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl($api_url)
                ->addHeaders(['content-type' => 'application/json']) // Set content type
                ->setContent($jsonData) // Set the JSON data as content
                ->send();
            if ($response->isOk) {
                $data = $response->getData();
                return $data['answer'] ?? 'No answer received.';
            } else {
                $errorDetails = $response->statusCode . ' - ' . $response->content;
                Yii::error('FastAPI request failed: ' . $errorDetails);
                return 'Error: API request failed (status code ' . $response->statusCode . '). See logs.';
            }

        } catch (\Exception $e) {
            Yii::error('Exception during FastAPI request: ' . $e->getMessage());
            return 'Error: An exception occurred during the API request.';
        }
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
