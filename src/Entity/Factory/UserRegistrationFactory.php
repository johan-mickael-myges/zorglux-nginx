<?php
namespace App\Entity\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function create(string $username, string $plainPassword): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $plainPassword));

        return $user;
    }
}
