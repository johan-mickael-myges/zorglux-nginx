<?php

namespace App\Security\Voter;

use App\Entity\Blog;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BlogVoter extends Voter {
    public const LIST = 'list';
    public const WRITE = 'write';
    public const READ = 'read';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (in_array($attribute, [
            self::LIST,
            self::WRITE,
        ])) {
            return true;
        }

        if (!$subject instanceof Blog) {
            return false;
        }

        if (in_array($attribute, [
            self::READ,
        ])) {
            return true;
        }

        return false;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if (in_array($attribute, [self::LIST, self::READ])) {
            return true;
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::WRITE => $this->canWrite(),
            default => false,
        };
    }

    private function canList(): bool
    {
        return true;
    }

    private function canWrite(): bool
    {
        return true;
    }

    private function canRead(): bool
    {
        return true;
    }
}
