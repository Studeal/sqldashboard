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
     private $dashboards;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nameComp", type="string", length=255)
     */
    private $nameComp;

    /**
     * @var string
     *
     * @ORM\Column(name="requestSQL", type="text")
     */
    private $requestSQL;

    /**
     * @var string
     *
     * @ORM\Column(name="typeGraph", type="string", length=15)
     */
    private $typeGraph = "linecharts";

    /**
     * @var string
     *
     * @ORM\Column(name="sizeComponent", type="string", length=10)
     */
    private $sizeComponent = "3";


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
}
