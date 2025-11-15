<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:create-user', description: 'Create a new user or admin account.')]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface      $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository              $userRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('admin', null, InputOption::VALUE_NONE, 'Create user with ROLE_ADMIN');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        // 1. Prompt for email
        $emailQuestion = new Question('Email: ');
        $emailQuestion->setValidator(function ($answer) {
            if (empty($answer)) {
                throw new \RuntimeException('Email cannot be empty');
            }
            if (!filter_var($answer, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('Invalid email format');
            }
            return $answer;
        });
        $email = $helper->ask($input, $output, $emailQuestion);

        // 2. Check if user already exists
        $existingUser = $this->userRepository->findOneBy(['email' => $email]);
        if ($existingUser) {
            $io->error(sprintf('User with email "%s" already exists', $email));
            return Command::FAILURE;
        }

        // 3. Prompt for password
        $passwordQuestion = new Question('Password: ');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $passwordQuestion->setValidator(function ($answer) {
            if (empty($answer)) {
                throw new \RuntimeException('Password cannot be empty');
            }
            if (strlen($answer) < 4) {
                throw new \RuntimeException('Password must be at least 4 characters');
            }
            return $answer;
        });
        $password = $helper->ask($input, $output, $passwordQuestion);

        // 4. Create user
        $user = new User();
        $user->setEmail($email);

        $isAdmin = $input->getOption('admin');
        $roles = $isAdmin ? ['ROLE_ADMIN', 'ROLE_USER'] : ['ROLE_USER'];
        $user->setRoles($roles);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        // 5. Persist
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(sprintf(
            'User created successfully with role%s: %s',
            count($roles) > 1 ? 's' : '',
            implode(', ', $roles)
        ));
        $io->table(['Email', 'Roles'], [[$email, implode(', ', $roles)]]);

        return Command::SUCCESS;
    }
}
