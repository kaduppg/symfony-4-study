<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="This email is already used")
 * @UniqueEntity(fields="username", message="This username is already used" )
 */
class User implements AdvancedUserInterface, \Serializable
{

    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="50")
     */
    private $username;


    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="8",max="4096")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(min="4",max="50")
     */
    private $fullName;

    /**
     * @var array
     * @ORM\Column(type="simple_array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MicroPost" , mappedBy="user")
     */
    private $posts;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="following")
     */
    private $followers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="followers")
     * @ORM\JoinTable(name="following",
     *      joinColumns={
     *          @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
                @ORM\JoinColumn(name="following_user_id", referencedColumnName="id")
     *      }
     *    )
     */
    private $following;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MicroPost", mappedBy="likedBy")
     */
    private $postLiked;


    /** @ORM\Column(type="string", nullable=true, length=30) */
    private $confirmationToken;

    /** @ORM\Column(type="boolean") */
    private $enabled;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->postLiked = new ArrayCollection();
        $this->roles = [self::ROLE_USER];
        $this->enabled = false;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {

    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->enabled
        ]);
    }

    public function unserialize($serialized)
    {
        list($this->id,
            $this->username,
            $this->password, $this->enabled) = unserialize($serialized);
    }



    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }



    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @return Collection
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @return Collection
     */
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * @return Collection
     */
    public function getPostLiked()
    {
        return $this->postLiked;
    }

    /**
     * @return mixed
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param mixed $confirmationToken
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }



    public function isAccountNonExpired(){
        return true;
    }


    public function isAccountNonLocked(){
        return true;
    }


    public function isCredentialsNonExpired(){
        return true;
    }


    public function isEnabled(){
        return $this->enabled;
    }

}
