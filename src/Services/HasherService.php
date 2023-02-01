<?php

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class HasherService
{
  public function __construct(private EntityManagerInterface $em){}

  public function hashUser(User $user)
  {
    $user->setEmail(md5($user->getEmail()));
    $user->setTelephone(md5($user->getTelephone()));
    $user->setFirstname(md5($user->getFirstname()));
    $user->setLastname(md5($user->getLastname()));

    $this->em->flush();
  }
}
