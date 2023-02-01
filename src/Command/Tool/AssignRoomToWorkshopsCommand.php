<?php

namespace App\Command\Tool;

use App\Entity\Workshop;
use App\Repository\ForumRepository;
use App\Repository\WorkshopRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: self::CMD,
    description: 'Assign a room to the workshops',
)]
class AssignRoomToWorkshopsCommand extends Command
{
    const CMD = 'workshop:assign-rooms';

    public function __construct(
        private ForumRepository $forumRepository,
        private WorkshopRepository $workshopRepository
    ) {
        parent::__construct(self::CMD);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $forum = $this->forumRepository->findLastForum();

        $workshops = $this->workshopRepository->findBy(['forum' => $forum]);

        usort($workshops, function (Workshop $w1, Workshop $w2){
            if ($w1->getNbPersons() < $w2->getNbPersons()) {
                return -1;
            } elseif ($w1->getNbPersons() > $w2->getNbPersons()) {
                return 1;
            } else {
                return 0;
            }
        });



        foreach ($workshops as $workshop) {
            dump($workshop->getNbPersons() . ' ' . $workshop->getName());
        }

        return Command::SUCCESS;
    }
}
