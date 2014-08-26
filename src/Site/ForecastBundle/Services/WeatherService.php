<?php
/**
 * Created by PhpStorm.
 * User: sergey.kiryakov
 * Date: 26.08.14
 * Time: 14:27
 */

namespace Site\ForecastBundle\Services;

use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class WeatherService {
    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    private $templating;

    public function __construct(EngineInterface     $templating)
    {
        $this->templating = $templating;
    }
    public function getDataWeather($town, $sumDays)
    {
        $link = "http://api.openweathermap.org/data/2.5/forecast/daily?q=".$town."&mode=json&units=metric&cnt=".$sumDays."&APPID=2172ade7c1f55aa1adff109d09d2b3bb";
        $data = (array)json_decode($this->securityLinkGet($link));
        if(!$data){
            $forecast = "Попробуйте другой город";
        }
        else{
            $listTemp = array();

            foreach($data['list'] as $day){
                $listTemp[] = $day->temp;
            }

            $forecast  = $this->templating->render('SiteForecastBundle:Default:forecast.html.twig', array(
                    'listTemp' => $listTemp,
                    'town'     => $town
                ));
        }

        return $forecast;
    }

    protected  function securityLinkGet($link)
    {
        $client = new Client();
        $request = $client->get($link);

        /**
         * @var $response Response
         */
        $response = $request->send();
        $data = $response->getBody();

        return $data;
    }
} 