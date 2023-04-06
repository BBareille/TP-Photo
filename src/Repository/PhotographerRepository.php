<?php

namespace App\Repository;

use App\Entity\Photographer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Photographer>
 *
 * @method Photographer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photographer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photographer[]    findAll()
 * @method Photographer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotographerRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photographer::class);
    }

    public function save(Photographer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Photographer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
        
        public function nbOfPhotoByUser($id)
        {
                $qb = $this->createQueryBuilder('u')
                            ->join("u.allowedFolders", "f")
                            ->join('f.childrenPhoto', 'p')
                            ->select('count(p.id)')
                            ->where('u.email = :id')
                            ->setParameter('id', $id);
                
                return $qb->getQuery()->getSingleScalarResult();
        }
        
        public function mostPopularFolder($id){
                
                return $this->createQueryBuilder('u')
                            ->join('u.allowedFolders', 'f')
                            ->join('f.childrenPhoto', 'p')
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
                            ->join('u.allowedFolders', 'f')
                            ->join('f.childrenPhoto', 'p')
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
                            ->join('u.allowedFolders', 'f')
                            ->join('f.childrenPhoto', 'p')
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
        public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
        {
                if (!$user instanceof Photographer) {
                        throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
                }
        
                $user->setPassword($newHashedPassword);
        
                $this->save($user, true);
        }
}
