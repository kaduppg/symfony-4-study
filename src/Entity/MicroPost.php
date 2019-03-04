<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MicroPostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class MicroPost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type = "string" , length=280)
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $text;

    /**
     * @ORM\Column(type = "datetime")
     */
    private $time;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User" , inversedBy="postLiked")
     * @ORM\JoinTable(name="post_likes",
     *     joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")}
     *     ,
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $likedBy;


    public function __construct()
    {
        $this->likedBy = new ArrayCollection();
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setTimeOnPersist(){
        $this->time = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getLikedBy()
    {
        return $this->likedBy;
    }

    public function like(User $user){
        if($this->likedBy->contains($user)){
            return;
        }

        $this->likedBy->add($user);
    }

}

