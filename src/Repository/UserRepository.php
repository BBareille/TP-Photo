<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }


    public function nbOfPhotoByUser($id)
    {
        $qb = $this->createQueryBuilder('u')
            ->join("u.folders", "f")
            ->join('f.photoCollection', 'p')
            ->select('count(p.id)')
            ->where('u.email = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function mostPopularFolder($id){

        return $this->createQueryBuilder('u')
            ->join('u.folders', 'f')
            ->join('f.photoCollection', 'p')
            ->select('f.name')
            ->where('u.email =:id')
            ->groupBy('f.id')
            ->setParameter('id', $id)
            ->orderBy('count(p.id)', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleColumnResult()
            ;
    }

    public function nbOfTagByUser($id){
        return $this->createQueryBuilder('u')
            ->join('u.folders', 'f')
            ->join('f.photoCollection', 'p')
            ->join('p.tags', 't')
            ->select('count(t.id)')
            ->where('u.email = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function mostPopularTag($id){
        return $this->createQueryBuilder('u')
            ->join('u.folders', 'f')
            ->join('f.photoCollection', 'p')
            ->join('p.tags', 't')
            ->select('t.name')
            ->where('u.email =:id')
            ->setParameter('id', $id)
            ->orderBy('count(t.id)', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
