<?php
/**
 * Created by PhpStorm.
 * User: sergey.kiryakov
 * Date: 26.08.14
 * Time: 12:55
 */

namespace Site\ForecastBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
* @ORM\Entity
 * @ORM\Table(name="weather_forecast_history")
 */
class WeatherForecastHistory {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="WeatherTowns", inversedBy="town")
     * @ORM\JoinColumn(name="town_id", referencedColumnName="id")
     */
    protected $townId;

    /**
     * @ORM\Column(name="duration", type="integer", nullable=false)
     */
    protected $duration;

    /**
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    protected $comment;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    protected $date;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $townId
     */
    public function setTownId($townId)
    {
        $this->townId = $townId;
    }

    /**
     * @return mixed
     */
    public function getTownId()
    {
        return $this->townId;
    }


} 