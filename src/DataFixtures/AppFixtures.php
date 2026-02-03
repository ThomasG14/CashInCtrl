<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserSetting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface  $passwordHasher){}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin')
            ->setPassword('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@cashinctrl.com')
        ;
        $password = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($password);

        $userSetting = new UserSetting();
        $userSetting->setAttachedUser($user)
            ->setLang('FR')
            ->setColorAccent('#bf0000')
            ->setUpdatedAt(new \DateTimeImmutable())
        ;

        $manager->persist($user);
        $manager->persist($userSetting);
        $manager->flush();
    }
}
