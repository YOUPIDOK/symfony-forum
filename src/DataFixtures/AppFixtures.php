<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Forum;
use App\Entity\HighSchool;
use App\Entity\Job;
use App\Entity\JobActivity;
use App\Entity\JobSkill;
use App\Entity\Room;
use App\Entity\Speaker;
use App\Entity\Student;
use App\Entity\User;
use App\Entity\Workshop;
use App\Entity\WorkshopReservation;
use App\Entity\WorkshopSector;
use App\Enum\HighSchoolDegreeEnum;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher) { }

    private ObjectManager $manager;
    private Forum         $forum;
    private array         $activities = [];
    private array         $skills = [];
    private array         $sectors = [];
    private array         $companies = [];
    private array         $workshops = [];
    private array         $speakers = [];
    private array         $highSchools = [];
    private array         $students = [];
    private array         $jobs = [];

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->forums();
        $this->activities();
        $this->skills();
        $this->jobs();
        $this->sectors();
        $this->rooms();
        $this->companies();
        $this->users();
        $this->speakers();
        $this->highSchools();
        $this->students();
        $this->workshops();
        $this->workshopReservations();
    }

    private function forums()
    {
        dump('FORUMS');
        $forum = (new Forum())
            ->setName('Forum 2023')
            ->setStartAt(new DateTime('2023-02-25 10:00:00'))
            ->setEndAt(new DateTime('2023-03-25 18:00:00'));

        $this->manager->persist($forum);
        $this->manager->flush();

        $this->forum = $forum;
    }

    private function skills()
    {
        dump('SKILLS');
        for ($i = 1; $i <= 50; $i++) {
            $skill = (new JobSkill())->setName('Compétence ' . $i);
            $this->manager->persist($skill);
            $this->skills[] = $skill;
        }

        $this->manager->flush();
    }

    private function activities()
    {
        dump('ACTIVITIES');

        for ($i = 1; $i <= 50; $i++) {
            $activity = (new JobActivity())->setName('Activité ' . $i);
            $this->manager->persist($activity);
            $this->activities[] = $activity;
        }

        $this->manager->flush();
    }

    private function jobs()
    {
        dump('JOBS');

        for ($i = 1; $i <= 5; $i++) {
            $job = (new Job())->setName('Métier ' . $i);

            $max = random_int(0, 5);
            for ($j = 0; $j < $max; $j++) {
                $skill = $this->skills[array_rand($this->skills)];
                if (!$job->getJobSkills()->contains($skill)) {
                    $job->addJobSkill($skill);
                }
            }

            $max = random_int(0, 5);
            for ($j = 0; $j < $max; $j++) {
                $activity = $this->activities[array_rand($this->activities)];
                if (!$job->getJobSkills()->contains($activity)) {
                    $job->addJobActivity($activity);
                }
            }

            $this->manager->persist($job);
            $this->jobs[] = $job;
        }

        $this->manager->flush();
    }

    private function sectors()
    {
        dump('SECTORS');

        for ($i = 1; $i <= 30; $i++) {
            $sector = (new WorkshopSector())
                ->setName('Secteur ' . $i)
                ->setDescription('Description du secteur ' . $i)
            ;
            $this->manager->persist($sector);
            $this->sectors[] = $sector;
        }

        $this->manager->flush();
    }

    private function companies()
    {
        dump('COMPANIES');

        for ($i = 1; $i <= 30; $i++) {
            $company = (new Company())->setName('Entreprise ' . $i);
            $this->manager->persist($company);
            $this->companies[] = $company;
        }

        $this->manager->flush();
    }

    private function users()
    {
        dump('USERS');

        $admin = (new User())
            ->setTelephone('0123456789')
            ->setEmail('admin@mail.fr')
            ->setFirstname('Prénom')
            ->setLastname('Nom')
            ->addRole('ROLE_ADMIN');

        $admin->setPassword($this->userPasswordHasher->hashPassword($admin,'password'));

        $this->manager->persist($admin);
        $this->manager->flush();
    }

    private function speakers()
    {
        dump('SPEAKERS');

        for ($i = 1; $i < 50; $i++) {
            $user = (new User())
                ->setTelephone('0123456789')
                ->setEmail('intervenant' . $i . '@mail.fr')
                ->setFirstname('Prénom')
                ->setLastname('Nom')
                ->addRole('ROLE_SPEAKER');

            $user->setPassword($this->userPasswordHasher->hashPassword($user,'password'));
            $this->manager->persist($user);

            $speaker = (new Speaker())
                ->setUser($user)
                ->setCompany($this->companies[array_rand($this->companies)]);
            $this->manager->persist($speaker);

            $this->speakers[] = $speaker;
            $this->manager->flush();
        }
    }

    private function highSchools()
    {
        dump('HIGH SCHOOLS');

        for ($i = 1; $i < 10; $i++) {
            $user = (new User())
                ->setTelephone('0123456789')
                ->setEmail('lycee' . $i . '@mail.fr')
                ->setFirstname('Prénom')
                ->setLastname('Nom')
                ->addRole('ROLE_HIGH_SCHOOL');

            $user->setPassword($this->userPasswordHasher->hashPassword($user,'password'));
            $this->manager->persist($user);

            $highSchool = (new HighSchool())
                ->setUser($user)
                ->setName('Lycée ' . $i);

            $this->manager->persist($highSchool);

            $this->highSchools[] = $highSchool;
            $this->manager->flush();
        }
    }

    private function students()
    {
        dump('STUDENTS');

        $degrees = HighSchoolDegreeEnum::getChoices();

        for ($i = 1; $i < 50; $i++) {
            $user = (new User())
                ->setTelephone('0123456789')
                ->setEmail('etudiant' . $i . '@mail.fr')
                ->setFirstname('Prénom')
                ->setLastname('Nom')
                ->addRole('ROLE_STUDENT');

            $user->setPassword($this->userPasswordHasher->hashPassword($user,'password'));
            $this->manager->persist($user);

            $student = (new Student())
                ->setUser($user)
                ->setDegree($degrees[array_rand($degrees)])
                ->setHighSchool($this->highSchools[array_rand($this->highSchools)]);

            $this->manager->persist($student);

            $this->students[] = $student;
            $this->manager->flush();
        }

    }

    private function rooms()
    {
        for ($i = 1; $i <= 50; $i++) {
            $room = (new Room())
                ->setName('Salle ' . $i)
                ->setAvailable(rand(0, 1))
                ->setFloor('Étage ' . random_int(0, 6))
                ->setCapacity(random_int(10, 300))
            ;
            $this->manager->persist($room);
        }

        $this->manager->flush();
    }

    private function workshops()
    {
        dump('WORKSHOPS');

        for ($i = 1; $i <= 20; $i++) {
            $startAt = $this->randomDate($this->forum->getStartAt(), $this->forum->getEndAt()->modify('-45min'));
            $workshop = (new Workshop())
                ->setName('Atelier ' . $i)
                ->setForum($this->forum)
                ->setSector($this->sectors[array_rand($this->sectors)])
                ->setStartAt($startAt)
                ->setEndAt((new DateTime($startAt->format('Y-m-d H:i:s')))->modify('-45 minutes'));

            $max = random_int(1, 3);
            for ($j = 0; $j < $max; $j++) {
                $speaker = $this->speakers[array_rand($this->speakers)];
                if (!$workshop->getSpeakers()->contains($speaker)) {
                    $workshop->addSpeaker($speaker);
                }
            }

            $max = random_int(1, 5);
            for ($j = 0; $j < $max; $j++) {
                $job = $this->jobs[array_rand($this->jobs)];
                if (!$workshop->getJobs()->contains($job)) {
                    $workshop->addJob($job);
                }
            }
            $this->manager->persist($workshop);
            $this->workshops[] = $workshop;
        }

        $this->manager->flush();
    }

    private function workshopReservations()
    {
        dump('WORKSHOP RESERVATIONS');

        foreach ($this->students as $student) {
            $max = random_int(0, 3);
            $workshops = [];
            for ($i = 1; $i <= $max; $i++) {
                $workshop = $this->workshops[array_rand($this->workshops)];

                if (!in_array($workshop, $workshops)) {
                    $reservation = (new WorkshopReservation())
                        ->setWorkshop($workshop)
                        ->setStudent($student);
                    $workshops[] = $workshop;

                    $this->manager->persist($reservation);
                }
            }

            $this->manager->flush();
        }
    }

    private function randomDate(DateTime $start_date, DateTime $end_date): DateTime
    {
        $min = $start_date->getTimestamp();
        $max = $end_date->getTimestamp();
        $val = rand($min, $max);

        return new DateTime(date('Y-m-d H:i:s', $val));
    }
}
