<?php

namespace AppBundle\Repository\User;

use AppBundle\Entity\User\User;
use AppBundle\Exception\NotExistsException;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use FOS\UserBundle\Util\PasswordUpdaterInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var CanonicalFieldsUpdater
     */
    protected $canonicalFieldsUpdater;

    /**
     * @var PasswordUpdaterInterface
     */
    protected $passwordUpdater;

    public function __construct(
        RegistryInterface $registry,
        UserManagerInterface $userManager,
        CanonicalFieldsUpdater $canonicalFieldsUpdater,
        PasswordUpdaterInterface $passwordUpdater
    ) {
        $this->doctrine               = $registry;
        $this->userManager            = $userManager;
        $this->canonicalFieldsUpdater = $canonicalFieldsUpdater;
        $this->passwordUpdater        = $passwordUpdater;
    }

    public function findOneById($uuid)
    {
        $user = $this->doctrine->getRepository(User::class)->findOneBy(['id' => $uuid]);

        if (null === $user) {
            throw new NotExistsException();
        }

        return $user;
    }

    public function findOneByEmail($email)
    {
        $user = $this->doctrine->getRepository(User::class)->findOneBy(['emailCanonical' => $this->canonicalFieldsUpdater->canonicalizeEmail($email)]);

        if (null === $user) {
            throw new NotExistsException();
        }

        return $user;
    }

    public function findOneByUsername($username)
    {
        $user = $this->doctrine->getRepository(User::class)->findOneBy(['usernameCanonical' => $this->canonicalFieldsUpdater->canonicalizeUsername($username)]);

        if (null === $user) {
            throw new NotExistsException();
        }

        return $user;
    }
}
