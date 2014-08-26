<?php

namespace Site\ForecastBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Site\ForecastBundle\Entity\WeatherForecastHistory;
use Site\ForecastBundle\Entity\WeatherTowns;
use Site\ForecastBundle\Form\WeatherType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WeatherController extends Controller

{
    public function indexAction(Request $request)
    {
        $em          = $this->get('doctrine.orm.entity_manager');
        $repo        = $em->getRepository('SiteForecastBundle:WeatherForecastHistory');
        $histories   = $repo->findBy(array(), array('id' => 'DESC'));
        $sumDays      = array();
        for($i = 1; $i < 15; $i++){
            $sumDays[$i] = $i;
        }
        $listHistory = array();
        if($histories){

            foreach ($histories as $history){
                $listHistory[$history->getId()] = $history->getTownId();
            }
        }
        else{
            $listHistory[] = 'Еще не было запросов';
        }

        $form    = $this->createForm(new WeatherType($listHistory, $sumDays));

        return $this->render('SiteForecastBundle:Default:index.html.twig', array(
                'form'  => $form->createView(),
            ));
    }

    public function getWeatherAction(Request $request)
    {
        $data    = $request->get('weather');
        $town    = $data['townId'];
        $sumDays = $data['duration'];
        $comment = $data['comment'];

        $forecast = $this->get('site.weather.service')->getDataWeather($town, $sumDays);

        $townExist =false;
        $city = $this->townExistAction($town);
        if($city){
            $townExist = "Такой город есть в Базе Данных";
        }


        $history = $this->writeHistory($town, $sumDays, $comment);

        return new JsonResponse(array(
            'status'    => 'ok',
            'forecast'  => $forecast,
            'townExist' => $townExist,
//            'history'   => $history
        ));
    }

    protected function townExistAction($town)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $listCity = $em->getRepository('SiteForecastBundle:WeatherTowns')->findAll();

        $result = false;

        foreach ($listCity as $city){
            if($town == $city){
                return  $result = true;
            }
        }
        $WeatherTown = new WeatherTowns();
        $WeatherTown->setTown($town);
        $em->persist($WeatherTown);
        $em->flush();

        return $result;

    }

    protected function writeHistory($town, $duration, $comment)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $history = new WeatherForecastHistory();
        $townId = $this->getTownEntity($town);
        $history->setTownId($townId);
        $history->setDuration($duration);
        $history->setComment($comment);
        try {
            $em->persist($history);
            $em->flush();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    protected function getTownEntity($town)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('SiteForecastBundle:WeatherTowns');
        $result = $repo->findOneBy(array(
                'town' => $town));

        return $result;
    }

}
