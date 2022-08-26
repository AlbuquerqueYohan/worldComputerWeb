<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateursFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setPseudo('admin_yohan');
        $user->setNom('Albuquerque');
        $user->setPrenom('Yohan');
        $user->setPassword($user->algoCryptage('yohanLyon'));
        $manager->persist($user);
        $manager->flush();
    }
}
