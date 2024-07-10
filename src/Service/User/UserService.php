<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;

class UserService
{
    public function __construct(
        private readonly Security $security,
        private readonly UserRepository $userRepository,
    )
    {
    }

    public function getCurrentUser(): ?User
    {
        $userInterface = $this->security->getUser();

        if (empty($userInterface)) {
            return null;
        }

        return $this->userRepository->find($userInterface->getId());
    }
}
