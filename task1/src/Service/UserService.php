<?php

namespace App\Service;

use App\Entity\User;
use Symfony\{
    Component\DependencyInjection\ContainerInterface,
    Component\Filesystem\Filesystem,
    Component\HttpFoundation\File\File,
    Component\HttpFoundation\Session\SessionInterface
};

/**
 * Class UserService
 *
 * @package App\Service
 */
class UserService
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var User
     */
    private $user;

    /**
     * UserService constructor.
     *
     * @param ContainerInterface $container
     * @param SessionInterface $session
     */
    public function __construct(ContainerInterface $container, SessionInterface $session)
    {
        $this->filesystem = new Filesystem();
        $this->container = $container;

        if ($session->has('auth')) {
            if (false === $this->loadUser($session->get('auth'))) {
                $session->clear();
            }
        }
    }

    /**
     * @param string $password
     *
     * @return bool
     */
    public function isPassword(string $password): bool
    {
        if (false === $this->isLoad()) {
            return false;
        }

        if (md5($password . $this->container->getParameter('user.pass.salt')) === $this->user->getPassword()) {
            return true;
        }

        $this->upAttempt();

        return false;
    }

    /**
     * @param string $hash
     *
     * @return bool
     */
    public function loadUser(string $hash): bool
    {
        $userPath = $this->container->getParameter('user.dir') . $hash;

        if ($this->filesystem->exists($userPath)) {
            $fileInfo = new File($userPath);

            if ($fileInfo->isReadable()) {
                $data = explode('|', file_get_contents($fileInfo->getPathname()));

                if (count($data) === 4) {
                    $this->user = new User($this->container);

                    $this->user->setUsername($data[0]);
                    $this->user->setPassword($data[1]);
                    $this->user->setCntAttempt($data[2]);
                    $this->user->setBlockTime($data[3]);

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param string $hash
     *
     * @return bool
     */
    public function updateUser(string $hash): bool
    {
        if (false === $this->isLoad()) {
            return false;
        }

        $userPath = $this->container->getParameter('user.dir') . $hash;

        if ($this->filesystem->exists($userPath)) {
            $fileInfo = new File($userPath);

            if ($fileInfo->isWritable()) {
                $this->filesystem->dumpFile($fileInfo->getPathname(), implode('|', $this->user->getFields()));
                return true;
            }
        }

        return false;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        if (false === $this->isLoad()) {
            return null;
        }

        return $this->user;
    }

    /**
     * @return null|string
     */
    public function getUserHash(): ?string
    {
        if (false === $this->isLoad()) {
            return null;
        }

        if (null !== $this->user->getUsername()) {
            return md5($this->user->getUsername());
        }

        return null;
    }

    /**
     * @return bool
     */
    public function upAttempt(): bool
    {
        if (false === $this->isLoad()) {
            return false;
        }

        $this->user->setCntAttempt($this->user->getCntAttempt() + 1);

        if ($this->updateUser($this->getUserHash())) {

            if ($this->user->getCntAttempt() >= $this->container->getParameter('user.error.max')) {
                $this->user->setCntAttempt(0);
                $this->user->setBlockTime((time() + $this->container->getParameter('user.error.time')));
                if (!$this->updateUser($this->getUserHash())) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isLoad(): bool
    {
        return !is_null($this->user);
    }
}
