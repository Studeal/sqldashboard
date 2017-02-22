<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Dashboard
 *
 * @ORM\Table(name="sqldashboard_dashboard")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DashboardRepository")
 */
class Dashboard
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $creator;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", cascade={"persist"})
     */
    private $collaborator;
    public function __construct()
    {
        $this->collaborator = new ArrayCollection();
    }
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
     * @return Dashboard
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
     * Set creator
     *
     * @param \AppBundle\Entity\User $creator
     *
     * @return Dashboard
     */
    public function setCreator(\AppBundle\Entity\User $creator)
    {
        $this->creator = $creator;
        return $this;
    }
    /**
     * Get creator
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreator()
    {
        return $this->creator;
    }
    /**
     * Add collaborator
     *
     * @param \AppBundle\Entity\User $collaborator
     *
     * @return Dashboard
     */
    public function addCollaborator(\AppBundle\Entity\User $collaborator)
    {
        $this->collaborator[] = $collaborator;
        return $this;
    }
    /**
     * Remove collaborator
     *
     * @param \AppBundle\Entity\User $collaborator
     */
    public function removeCollaborator(\AppBundle\Entity\User $collaborator)
    {
        $this->collaborator->removeElement($collaborator);
    }
    /**
     * Get collaborator
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollaborator()
    {
        return $this->collaborator;
    }
}