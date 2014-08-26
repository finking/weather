<?php
/**
 * Created by PhpStorm.
 * User: sergey.kiryakov
 * Date: 26.08.14
 * Time: 14:10
 */

namespace Site\ForecastBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="weather_town")
 */
class WeatherTowns {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="town", type="string", nullable=false)
     * @ORM\OnetoMany(targetEntity="WeatherForecastHistory", mappedBy="townId")
     */
    protected $town;

    public function __construct()
    {
        $this->town = new ArrayCollection();
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
     * @param mixed $town
     */
    public function setTown($town)
    {
        $this->town = $town;
    }

    /**
     * @return mixed
     */
    public function getTown()
    {
        return $this->town;
    }

    public function __toString()
    {
        return $this->town;
    }
} 