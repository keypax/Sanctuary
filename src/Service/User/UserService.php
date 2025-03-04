<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepositoryInterface $userRepository
    ) {}

    public function createUser(User $user, string $plainPassword): void
    {
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));

        $this->userRepository->save($user);
    }
}