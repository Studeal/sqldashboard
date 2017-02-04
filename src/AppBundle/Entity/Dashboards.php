<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dashboards
 *
 * @ORM\Table(name="dashboards")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DashboardsRepository")
 */
class Dashboards
{
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="dashboards")
     */
    protected $user;

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
     * @ORM\Column(name="nameDash", type="string", length=255)
     */
    protected $nameDash;

    /**
     * @var int
     *
     * @ORM\Column(name="idUsersCreator", type="integer")
     */
    private $idUsersCreator;


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
     * Set nameDash
     *
     * @param string $nameDash
     *
     * @return Dashboards
     */
    public function setNameDash($nameDash)
    {
        $this->nameDash = $nameDash;

        return $this;
    }

    /**
     * Get nameDash
     *
     * @return string
     */
    public function getNameDash()
    {
        return $this->nameDash;
    }

    /**
     * Set idUsersCreator
     *
     * @param integer $idUsersCreator
     *
     * @return Dashboards
     */
    public function setIdUsersCreator($idUsersCreator)
    {
        $this->idUsersCreator = $idUsersCreator;

        return $this;
    }

    /**
     * Get idUsersCreator
     *
     * @return int
     */
    public function getIdUsersCreator()
    {
        return $this->idUsersCreator;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Dashboards
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }
}
