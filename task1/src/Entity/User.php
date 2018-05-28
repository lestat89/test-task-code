<?php

namespace App\Entity;

use Symfony\{
    Component\DependencyInjection\ContainerInterface,
    Component\Validator\Constraints as Assert,
    Component\Validator\Context\ExecutionContextInterface
};

/**
 * Class User
 *
 * @package App\Entity
 */
class User
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[a-z]+$/i")
     * @Assert\Type(type="string")
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $password;

    /**
     * @Assert\Type(type="int")
     */
    private $cntAttempt;

    /**
     * @Assert\Type(type="int")
     */
    private $blockTime;

    /**
     * User constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return int|null
     */
    public function getCntAttempt(): ?int
    {
        return $this->cntAttempt;
    }

    /**
     * @return int|null
     */
    public function getBlockTime(): ?int
    {
        return $this->blockTime;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return [
            $this->username,
            $this->password,
            $this->cntAttempt,
            $this->blockTime
        ];
    }

    /**
     * @param $password
     *
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param $username
     *
     * @return User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param int $cntAttempt
     *
     * @return User
     */
    public function setCntAttempt(int $cntAttempt): self
    {
        $this->cntAttempt = $cntAttempt;

        return $this;
    }

    /**
     * @param int $blockTime
     *
     * @return User
     */
    public function setBlockTime(int $blockTime): self
    {
        $this->blockTime = $blockTime;

        return $this;
    }

    /**
     * @Assert\Callback()
     *
     * @param ExecutionContextInterface $context
     *
     * @return bool
     */
    public function validate(ExecutionContextInterface $context)
    {
        $userService = $this->container->get('user.service');

        if (false === $userService->loadUser(md5($context->getObject()->getUsername()))) {
            $context->buildViolation('The user does not exist')->atPath('username')->addViolation();
            return false;
        }

        $maxLimitAttempt = $this->container->getParameter('user.error.max');
        $blockTime = $userService->getUser()->getBlockTime();

        if ($userService->getUser()->getCntAttempt() >= $maxLimitAttempt) {
            $context->buildViolation("The maximum number of attempts of an input, at most {$maxLimitAttempt} within {$blockTime} seconds is exceeded {$maxLimitAttempt}")->atPath('username')->addViolation();
            return false;
        }

        if ($blockTime > time()) {
            $blockTimeLeft = $blockTime - time();
            $context->buildViolation("The maximum number of attempts of an input is exceeded. The account will be unblocked in {$blockTimeLeft} seconds")->atPath('username')->addViolation();
            return false;
        }

        if (false === $userService->isPassword($context->getObject()->getPassword())) {
            $context->buildViolation('Incorrect password')->atPath('password')->addViolation();
            return false;
        }

    }
}
