<?php

namespace App\Command\Tool;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'user:create',
    description: 'User creation',
)]
class UserCreateCommand extends Command
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $userPasswordHasher,
    ){
        parent::__construct('user:create');
        $this->em = $em;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $userRepo = $this->em->getRepository(User::class);

        $user = (new User())
            ->setFirstname($io->ask('Firstname '))
            ->setLastname($io->ask('Lastname '))
            ->setTelephone($io->ask('Telephone '))
            ->setEmail($io->ask('E-mail ', null, function ($email) use ($userRepo) {
                if ($userRepo->findOneBy(['email' => $email]) !== null) {
                    throw new \RuntimeException('User already exist');
                }

                return $email;
            }))
        ;

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $io->askHidden('Password')));

        if ($io->confirm('Is admin ?', false)) {
            $user->addRole('ROLE_ADMIN');
        }

        $addNewRole = $io->confirm('Other role ? ', false);
        while ($addNewRole) {
            $user->addRole($io->ask('Role ',''));
            $addNewRole = $io->confirm('Other role ?', false);
        }

        $this->em->persist($user);
        $this->em->flush();

        $io->success($user->getIdentity() . ' has been generated.');

        return Command::SUCCESS;
    }
}
