<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Component
 *
 * @ORM\Table(name="sqldashboard_component")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComponentRepository")
 */
class Component
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dashboard")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dashboard;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name = "";

    /**
     * @var string
     *
     * @ORM\Column(name="requestSQL", type="text")
     */
    private $requestSQL = "";

    /**
     * @var string
     *
     * @ORM\Column(name="typeGraph", type="string", length=255)
     */
    private $typeGraph = "column";

    /**
     * @var string
     *
     * @ORM\Column(name="sizeComponent", type="string", length=10)
     */
    private $sizeComponent = "3";

    /**
     * @var string
     *
     * @ORM\Column(name="legend", type="string", length=255)
     */
    private $legend = "";

    /**
     * @var string
     *
     * @ORM\Column(name="xAxis", type="string", length=255)
     */
    private $xAxis = "";

    /**
     * @var string
     *
     * @ORM\Column(name="yAxis", type="string", length=255)
     */
    private $yAxis = "";


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Component
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set requestSQL
     *
     * @param string $requestSQL
     *
     * @return Component
     */
    public function setRequestSQL($requestSQL)
    {
        $this->requestSQL = $requestSQL;

        return $this;
    }

    /**
     * Get requestSQL
     *
     * @return string
     */
    public function getRequestSQL()
    {
        return $this->requestSQL;
    }

    /**
     * Set typeGraph
     *
     * @param string $typeGraph
     *
     * @return Component
     */
    public function setTypeGraph($typeGraph)
    {
        $this->typeGraph = $typeGraph;

        return $this;
    }

    /**
     * Get typeGraph
     *
     * @return string
     */
    public function getTypeGraph()
    {
        return $this->typeGraph;
    }

    /**
     * Set sizeComponent
     *
     * @param string $sizeComponent
     *
     * @return Component
     */
    public function setSizeComponent($sizeComponent)
    {
        $this->sizeComponent = $sizeComponent;

        return $this;
    }

    /**
     * Get sizeComponent
     *
     * @return string
     */
    public function getSizeComponent()
    {
        return $this->sizeComponent;
    }

    /**
     * Set legend
     *
     * @param string $legend
     *
     * @return Component
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    /**
     * Get legend
     *
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * Set xAxis
     *
     * @param string $xAxis
     *
     * @return Component
     */
    public function setXAxis($xAxis)
    {
        $this->xAxis = $xAxis;

        return $this;
    }

    /**
     * Get xAxis
     *
     * @return string
     */
    public function getXAxis()
    {
        return $this->xAxis;
    }

    /**
     * Set yAxis
     *
     * @param string $yAxis
     *
     * @return Component
     */
    public function setYAxis($yAxis)
    {
        $this->yAxis = $yAxis;

        return $this;
    }

    /**
     * Get yAxis
     *
     * @return string
     */
    public function getYAxis()
    {
        return $this->yAxis;
    }

    /**
     * Set dashboard
     *
     * @param \AppBundle\Entity\Dashboard $dashboard
     *
     * @return Component
     */
    public function setDashboard(\AppBundle\Entity\Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;

        return $this;
    }

    /**
     * Get dashboard
     *
     * @return \AppBundle\Entity\Dashboard
     */
    public function getDashboard()
    {
        return $this->dashboard;
    }
}
