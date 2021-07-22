<?php
namespace frontend\components;

use yii\base\Component;

class TripsterComponent extends Component
{
	/*
	 * URL fro RestAPI
	 */
	const URL = 'http://experience.tripster.ru/';

	/**
	 * Partner marker
	 * @var string
	 * @access private
	 */
	private $partner;
	
	/**
	 * Class constructor
	 * @param string $partner
	 * @return void
	 * @access public
	 * @final
	 */
	final public function __construct($partner)
	{
		$this->partner = $partner;
	}
	
	/**
	 * Get all cities from tripster.ru
	 * @return array
	 * @access public
	 * @final
	 */
	final public function getCities()
	{
		// this sh..t returning not a json
		$result = file_get_contents(self::URL . 'api/cities');
		
		return explode(PHP_EOL, $result);
	}
	
	/**
	 * Get info by city IATA
	 * @param string $iata
	 * @param boolean $shortText
	 * @return array
	 * @access public
	 * @final
	 */
	final public function getCity($name_ru, $shortText = false)
	{
		return $this->request('api/cities', [
			// 'iata' => strtoupper($iata),
			'name_ru' => $name_ru,
			'template' => 'json',
			'order' => 'top',
			'short_text' => $shortText?'true':'false',
			'partner' => $this->partner
		]);
	}

	/**
	 * Execution of the request
	 * @param string $path
	 * @param array $parameters
	 * @return mixed
	 * @access private
	 */
	private function request($path, array $parameters = null)
	{
		$url = self::URL.$path;
		
		if ($parameters)
			$parameters = '?'.http_build_query($parameters);
			
		$result = file_get_contents($url.$parameters);
		
		return json_decode($result, true);
	}
}