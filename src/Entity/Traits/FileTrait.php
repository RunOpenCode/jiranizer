<?php

namespace AppBundle\Entity\Traits;

use Stringy\Stringy;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as HttpFile;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile as HttpUploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Vich\Uploadable
 */
trait FileTrait
{
    use TimestampableEntity;
    use BlameableEntity;

    /**
     * @var \Ramsey\Uuid\Uuid
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\Type(type="integer", groups={"valid_file"})
     * @Assert\GreaterThan(value=0, groups={"valid_file"})
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Type(type="string", groups={"valid_file"})
     */
    private $mime;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Type(type="string", groups={"valid_file"})
     * @Assert\Length(max=255, groups={"valid_file"})
     */
    private $title;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @return HttpFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param HttpFile $file
     * @return FileTrait
     */
    public function setFile(HttpFile $file = null)
    {
        $this->file = $file;

        if ($file) {
            $this->updatedAt = new \DateTime('now');
            $this->size = (!$file instanceof HttpUploadedFile) ? $file->getSize() : $file->getClientSize();
            $this->mime = (!$file instanceof HttpUploadedFile) ? $file->getMimeType() : $file->getClientMimeType();

            if (!$this->title) {
                $title = (!$file instanceof HttpUploadedFile) ? $file->getFilename() : $file->getClientOriginalName();
                $this->title = (string) Stringy::create($title)->humanize();
            }
        }

        return $this;
    }

    /**
     * @return Uuid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function getExtension()
    {
        return ExtensionGuesser::getInstance()->guess($this->mime);
    }
}
