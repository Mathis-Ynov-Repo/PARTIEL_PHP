<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\User;
use App\Utils\PriceEstimation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;
    private $price;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface, PriceEstimation $priceEstimation)
    {
        $this->passwordEncoder = $userPasswordEncoderInterface;
        $this->price = $priceEstimation;
    }
    public function load(ObjectManager $manager)
    {

        $faker = Factory::Create();

        for ($compteur = 0; $compteur < 100; $compteur++) {
            $advert = new Advert();
            $advert->setTitle($faker->sentence($nbWords = 2, $variableNbWords = true))
            ->setDescription($faker->paragraph($nbSentences = 3, $variableNbSentences = true))
            ->setCity($faker->city())
            ->setCarYear($faker->numberBetween($min = 2000, $max = 2020))
            ->setNbKm($faker->numberBetween($min = 100, $max = 10000))
            ->setNbDays($faker->numberBetween($min = 2, $max = 90))
            ->setPrice($this->price->getPrice($advert->getCarYear(),$advert->getNbKm(), $advert->getNbDays()));

            $manager->persist($advert);
        }


        $user = new User();
        $user->setEmail('bob@bob.bob')
            ->setRoles(['ROLE_USER'])
            ->setLogin('Bobby')
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'bobby12345'
            ));
            $manager->persist($user);

        $admin = new User();
        $admin->setEmail('admin@admin.admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setLogin('Admin')
            ->setPassword($this->passwordEncoder->encodePassword(
                $admin,
                'admin'
            ));

            $manager->persist($admin);

        $manager->flush();
    }
}
