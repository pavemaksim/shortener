<?php

namespace App\Repository;

use App\Entity\ShortUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShortUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortUrl[]    findAll()
 * @method ShortUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortUrlRepository extends ServiceEntityRepository
{
    /**
     * ShortUrlRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortUrl::class);
    }

    /**
     * Find an instance by shortCode
     *
     * @param string $shortCode
     * @return ShortUrl
     */
    public function findByShortCode(string $shortCode)
    {
        $qb = $this->createQueryBuilder('su')
            ->where('su.expiredAt > :now')
            ->orWhere('su.expiredAt IS NULL')
            ->andWhere('su.shortCode = :shortCode')
            ->setParameter('shortCode', $shortCode)
            ->setParameter('now', new \DateTime('now'));

        return $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}
