<?php

namespace App\Command\Tool;

use App\Repository\StudentRepository;
use App\Services\HasherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: self::CMD,
    description: 'hash student user',
)]
class HashStudentsCommand extends Command
{
    const CMD = 'hash:students';

    public function __construct(
        private HasherService $hasherService,
        private StudentRepository $studentRepository,
        private EntityManagerInterface $em
    ) {
        parent::__construct(self::CMD);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $students = $this->studentRepository->findAll();

        foreach ($students as $student) {
            $this->hasherService->hashUser($student->getUser(), false);
        }

        $this->em->flush();

        $io->success("User hasher");
        
        return Command::SUCCESS;
    }
}
