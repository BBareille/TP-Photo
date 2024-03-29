<?php

namespace App\DataFixtures;

use App\Factory\ClientFactory;
use App\Factory\PhotoFactory;
use App\Factory\PhotographerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PhotographerFactory::createOne([
                "roles" => ['ROLE_PHOTO'],
                "email" => 'photo@photo.fr',
                'password' => '$2y$13$mylktairAOB.S.UodSt4aeO4mqxbr3mNLrLNIe7OqkQM6vHKizgUC'
            ]);

        ClientFactory::createOne([
            "roles" => ['ROLE_USER'],
            "email" => 'user@user.fr',
            'password' => '$2y$13$mylktairAOB.S.UodSt4aeO4mqxbr3mNLrLNIe7OqkQM6vHKizgUC'
        ]);

//        FolderFactory::createOne([
//            'owner' => PhotographerFactory::random()
//        ]);

        PhotoFactory::createMany(10);





    }
}
