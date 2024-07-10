<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:add-admin',
    description: 'Adds an admin user.'
)]
class AddAdminCommand extends Command
{
    protected static $defaultName = 'app:add-admin';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordEncoder)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Adds an admin user.')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the admin user')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the admin user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $user->setRoles(['ROLE_ADMIN']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Default admin user added.');

        return Command::SUCCESS;
    }
}
