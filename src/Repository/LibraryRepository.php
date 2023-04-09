<?php

namespace App\Repository;

use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LibraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Library::class);
    }

    public function findLibrariesByUser($userId)
    {
        return $this->createQueryBuilder('l')
            ->where('l.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findLibrariesByWishList($wishListId)
    {
        return $this->createQueryBuilder('l')
            ->join('l.wishLists', 'w')
            ->where('w.id = :wishListId')
            ->setParameter('wishListId', $wishListId)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
