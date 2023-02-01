<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class HasherService
{
  public function __construct(private EntityManagerInterface $em){}

  public function hashUser(User $user, ?bool $flush = true)
  {
    $user->setEmail(substr(md5($user->getEmail()), 0, 10));
    $user->setTelephone(substr(md5($user->getTelephone()), 0, 10));
    $user->setFirstname(substr(md5($user->getFirstname()), 0, 10));
    $user->setLastname(substr(md5($user->getLastname()), 0, 10));

    if ($flush) $this->em->flush();
  }
}
