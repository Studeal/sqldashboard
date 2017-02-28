<?php

<<<<<<< HEAD
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="sqldashboard_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
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
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     *
     */
    protected $image;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstNam
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return User
     */
    public function setImage($file)
    {
        $this->image = $file;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
=======
    namespace AppBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
    * User
    *
    * @ORM\Table(name="sqldashboard_user")
    * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
    */
    class User
    {
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
        * @ORM\Column(name="firstName", type="string", length=255)
        */
        protected $firstName;

        /**
        * @var string
        *
        * @ORM\Column(name="lastName", type="string", length=255)
        */
        protected $lastName;

        /**
        * @var string
        *
        * @ORM\Column(name="email", type="string", length=255)
        */
        protected $email;

        /**
        * @var string
        *
        * @ORM\Column(name="password", type="string", length=255)
        */
        protected $password;

        /**
        * @var string
        *
        * @ORM\Column(name="image", type="string", length=255)
        */
        protected $image;

        /**
        * @var bool
        *
        * @ORM\Column(name="status", type="boolean")
        */
        protected $status;    

        /**
        * Get id
        *
        * @return integer
        */
        public function getId()
        {
            return $this->id;
        }

        /**
        * Set firstName
        *
        * @param string $firstName
        *
        * @return User
        */
        public function setFirstName($firstName)
        {
            $this->firstName = $firstName;

            return $this;
        }

        /**
        * Get firstName
        *
        * @return string
        */
        public function getFirstName()
        {
            return $this->firstName;
        }

        /**
        * Set lastName
        *
        * @param string $lastName
        *
        * @return User
        */
        public function setLastName($lastName)
        {
            $this->lastName = $lastName;

            return $this;
        }

        /**
        * Get lastName
        *
        * @return string
        */
        public function getLastName()
        {
            return $this->lastName;
        }

        /**
        * Set email
        *
        * @param string $email
        *
        * @return User
        */
        public function setEmail($email)
        {
            $this->email = $email;

            return $this;
        }

        /**
        * Get email
        *
        * @return string
        */
        public function getEmail()
        {
            return $this->email;
        }

        /**
        * Set password
        *
        * @param string $password
        *
        * @return User
        */
        public function setPassword($password)
        {
            $this->password = $password;

            return $this;
        }

        /**
        * Get password
        *
        * @return string
        */
        public function getPassword()
        {
            return $this->password;
        }

        /**
        * Set image
        *
        * @param string $image
        *
        * @return User
        */
        public function setImage($image)
        {
            $this->image = $image;

            return $this;
        }

        /**
        * Get image
        *
        * @return string
        */
        public function getImage()
        {
            return $this->image;
        }
    

        /**
        * Set status
        *
        * @param boolean $status
        *
        * @return User
        */
        public function setStatus($status)
        {
            $this->status = $status;

            return $this;
        }

        /**
        * Get status
        *
        * @return boolean
        */
        public function getStatus()
        {
            return $this->status;
        }
    }
>>>>>>> 360de5359e57b84b807162fd5d93000696dc3f61
