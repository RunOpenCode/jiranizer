<?php

namespace AppBundle\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"email"})
 * @UniqueEntity(fields={"username"})
 */
class User extends BaseUser
{
    use TimestampableEntity;
    use BlameableEntity;

    /**
     * @var \Ramsey\Uuid\Uuid
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @Serializer\Groups({"session_list"})
     */
    protected $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User\Jira", mappedBy="user")
     *
     * @Assert\Valid()
     */
    private $jiras;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User\Photo", cascade={"all"})
     *
     * @Assert\Type(type="AppBundle\Entity\User\Photo", groups={
     *     "user_sign_up"
     * })
     * @Assert\Valid()
     */
    private $photo;

    public function __construct()
    {
        parent::__construct();
        $this->id    = Uuid::uuid4();
        $this->jiras = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getJiras()
    {
        return $this->jiras;
    }

    /**
     * @param ArrayCollection $jiras
     * @return User
     */
    public function setJiras($jiras)
    {
        $this->jiras = $jiras;
        return $this;
    }

    /**
     * @return Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param Photo $photo
     *
     * @return User
     */
    public function setPhoto(Photo $photo = null)
    {
        if (null === $photo || null !== $photo->getFile()) {
            $this->photo = $photo;
        }

        return $this;
    }
}
