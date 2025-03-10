<?php

namespace App\Repository\User;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
}