<?php

namespace backend\modules\parser\models;

class WikiAPI {
    private $token;
  
    public function __construct($token) {
        // $this->token = $token;
    }
  
    // GET-запрос на указанный ресурс с переданными параметрами
    public function get(array $parameters = array()) {
        $query_string = http_build_query($parameters);
        $curl = curl_init("https://ru.wikipedia.org/w/api.php?$query_string");
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                // 'Authorization: Token '.$this->token,
                'Content-Type: application/json',
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36'
            )
        ));
  
        // Получаем данные и закрывааем соединение
        $results = curl_exec($curl);
        curl_close($curl);
  
        // Декодируем полученный json
        // параметр true для возвращения ассоциативного массива вместо объекта
        // return json_decode($results, true);
        return json_decode($results, true);
    }
}
  
  
/******************************************************
 * Пример 1: Получаем экскурсии в Москве (первые 10)
 ******************************************************/
// $api = new TripsterAPI("xxxxxxxxxx6614887d94913470d64e1775c9a33c");
// $result = $api->get("experiences", array("city__name_ru" => "Москва"));
// print_r($result);
  
// /******************************************************
//  * Пример 2: Получаем все экскурсии в Москве
//  * и складываем в отдельный массив
//  ******************************************************/
// $api = new TripsterAPI("xxxxxxxxxx6614887d94913470d64e1775c9a33c");
// $experiences = array();
  
// $page = 1;
// while(true) {
//     print("Страница $page\n");
  
//     $page_results = $api->get("experiences", array(
//         "city__name_ru" => "Москва",
//         "page_size" => 100,
//         "page" => $page,       
//     ));
  
//     // Добавляем экскурсии к общему массиву экскурсий
//     $experiences = array_merge($experiences, $page_results["results"]);
  
//     // Если это последняя страница — заканчиваем, иначе запрашиваем следующую
//     if (!$page_results["next"]) break;
//     $page++;
// }
  
// // Выводим число экскурсий
// $experiences_count = count($experiences);
// print "Всего экскурсий в Москве: $experiences_count\n";
  
  
// /******************************************************
//  * Пример 3: Получаем все экскурсии в Москве
//  * и складываем рубрики в отдельный массив
//  ******************************************************/
// $api = new TripsterAPI("xxxxxxxxxx6614887d94913470d64e1775c9a33c");
// $tags = array();
  
// $page = 1;
// while(true) {
//     print("Страница $page\n");
  
//     $page_results = $api->get("experiences", array(
//         "city__name_ru" => "Москва",
//         "page_size" => 15,
//         "page" => $page,   
//     ));
  
//     // Вытаскиваем рубрики из каждой экскурсии и добавляем их
//     // в общий ассоциативный массив id => рубрика
//     foreach ($page_results["results"] as $experience) {
//         foreach ($experience["tags"] as $tag) {
//             $tags[$tag["id"]] = $tag;
//         }
//     }
  
//     // Если это последняя страница заканчиваем
//     if (!$page_results["next"]) break;
//     $page++;
// }
  
// // Выводим число рубрик
// $tags_count = count($tags);
// print "Число рубрик в Москве: $tags_count\n";
  
  
// /******************************************************
//  * Пример 4: Получаем рубрики экскурсии в Москве
//  * одним запросом
//  ******************************************************/
// $api = new TripsterAPI("xxxxxxxxxx6614887d94913470d64e1775c9a33c");
// $result = $api->get("citytags", array(
//     "city__name_ru" => "Москва",
//     "page_size" => 30,
// ));
// $tags = $result["results"];
  
// // Выводим число рубрик
// $tags_count = count($tags);
// print "Число рубрик в Москве: $tags_count\n";