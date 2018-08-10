<?php

namespace AppBundle\Entity\User;

use AppBundle\Entity\Traits\FileTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File as HttpFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user_photo")
 * @Vich\Uploadable
 */
class Photo
{
    use FileTrait;

    /**
     * @var HttpFile
     *
     * @Vich\UploadableField(mapping="profile_photo", fileNameProperty="name", size="size")
     *
     * @Assert\File(maxSize="3M", mimeTypes={
     *     "image/jpg",
     *     "image/jpeg",
     *     "image/png",
     *     "image/pdf"
     * }, groups={
     *     "user_sign_up"
     * })
     */
    private $file;
}
