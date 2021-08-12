<?php

namespace backend\modules\parser\controllers;

use Yii;
use yii\helpers\Url;
use GuzzleHttp\Client;
use backend\modules\parser\models\Parser;
use backend\modules\parser\models\TripsterAPI;
use common\models\City;
use common\models\Place;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use GuzzleHttp\Exception\ConnectException;
use yii\debug\models\search\Log;
use yii\log\Logger;
use yii\web\UploadedFile;
use backend\jobs\CityByTripsterJob;
use backend\modules\parser\models\TripsterForm;

/**
 * ParsingController implements the CRUD actions for Parser model.
 */
class TripsterController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'verbs' => [
        'class' => VerbFilter::class,
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  /**
   * Lists all Parser models.
   * @return mixed
   */
  public function actionIndex()
  {
    if (Yii::$app->request->post()) {
      $api = new TripsterAPI("41323de3f24c6a81d6bca4ac1cdf13c4d4089350");
      $page = 1;
      $countSave = 0;
      while($page < 65) {
          $page_results = $api->get("cities", ["page" => $page]);

          // Добавляем экскурсии из России к общему массиву экскурсий
          foreach($page_results['results'] as $item) {
            if($item['country']['name_ru'] == "Россия") {
              Yii::$app->queue->push(new CityByTripsterJob([
                  'city' => $item,
                  'pathinfo' => pathinfo($item['image']['cover']),
              ]));
              $countSave++;
            }
          }
        
          // Если это последняя страница — заканчиваем, иначе запрашиваем следующую
          if (!$page_results["next"]) break;
          $page++;
      }

      Yii::$app->session->setFlash('success', "Успешно запущено {$countSave} записей в очередь.");
    }

    return $this->render('index', [
    ]);
  }


}
