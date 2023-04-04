<?php

namespace App\DataFixtures;

use App\Entity\Folder;
use App\Entity\Photo;
use App\Factory\FolderFactory;
use App\Factory\PhotoFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Tests\Models\Enums\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne()
            ->setRoles(['ROLE_PHOTO'])
            ->setEmail('photo@photo.fr')
            ->setPassword('$2y$13$mylktairAOB.S.UodSt4aeO4mqxbr3mNLrLNIe7OqkQM6vHKizgUC');

        PhotoFactory::createMany(50);

        FolderFactory::createMany(5, function() {
            return [
                'PhotoCollection' => PhotoFactory::randomRange(1,5),
                'subFolders' => FolderFactory::createMany(2),
                'owner' => UserFactory::createOne(),
                ];
        });



        UserFactory::createOne([
            "roles" => ['ROLE_USER'],
            "email" => 'user@user.fr',
            'password' => '$2y$13$mylktairAOB.S.UodSt4aeO4mqxbr3mNLrLNIe7OqkQM6vHKizgUC'
        ]);
    }
}
