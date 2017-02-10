<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Components
 *
 * @ORM\Table(name="components")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComponentsRepository")
 */
class Components
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dashboards")
     * @ORM\JoinColumn(nullable=false)
     */
     protected $dashboards;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nameComp", type="string", length=255)
     */
    protected $nameComp = "";

    /**
     * @var string
     *
     * @ORM\Column(name="requestSQL", type="text")
     */
    protected $requestSQL = "";

    /**
     * @var string
     *
     * @ORM\Column(name="typeGraph", type="string", length=15)
     */
    protected $typeGraph = "column";

    /**
     * @var string
     *
     * @ORM\Column(name="sizeComponent", type="string", length=10)
     */
    protected $sizeComponent = "3";

    /**
     * @var string
     *
     * @ORM\Column(name="legend", type="string", length=255)
     */
    protected $legend = "";

    /**
     * @var string
     *
     * @ORM\Column(name="xAxis", type="string", length=255)
     */
    protected $xAxis = "";

    /**
     * @var string
     *
     * @ORM\Column(name="yAxis", type="string", length=255)
     */
    protected $yAxis = "";

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
     * Set nameComp
     *
     * @param string $nameComp
     *
     * @return Components
     */
    public function setNameComp($nameComp)
    {
        $this->nameComp = $nameComp;

        return $this;
    }

    /**
     * Get nameComp
     *
     * @return string
     */
    public function getNameComp()
    {
        return $this->nameComp;
    }

    /**
     * Set requestSQL
     *
     * @param string $requestSQL
     *
     * @return Components
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
     * @return Components
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
     * @return Components
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
     * Set dashboards
     *
     * @param \AppBundle\Entity\Dashboards $dashboards
     *
     * @return Components
     */
    public function setDashboards(\AppBundle\Entity\Dashboards $dashboards)
    {
        $this->dashboards = $dashboards;

        return $this;
    }

    /**
     * Get dashboards
     *
     * @return \AppBundle\Entity\Dashboards
     */
    public function getDashboards()
    {
        return $this->dashboards;
    }

    /**
     * Set legend
     *
     * @param string $legend
     *
     * @return Components
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
     * @return Components
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
     * @return Components
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
}
