<?php

namespace App\Repository;

use App\Entity\ShortUrl;
use App\Service\Url\ShortCodeInterface;
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
     * @param ShortCodeInterface
     */
    private $shortCodeService;

    /**
     * @param EntityManagerInterface
     */
    private $em;

    /**
     * ShortUrlRepository constructor.
     *
     * @param ManagerRegistry $registry
     * @param ShortCodeInterface $shortCodeService
     * @param EntityManagerInterface $em
     */
    public function __construct(ManagerRegistry $registry, ShortCodeInterface $shortCodeService, EntityManagerInterface $em)
    {
        $this->shortCodeService = $shortCodeService;
        $this->em = $em;

        parent::__construct($registry, ShortUrl::class);
    }

    /**
     * Creates a new ShortUrl record with shortCode being generated
     *
     * @param $formData
     */
    public function create($formData)
    {
        $shortUrl = $formData;
        $shortUrl->setShortCode($this->shortCodeService->generateCode());

        $entityManager = $this->em;
        $entityManager->persist($shortUrl);
        $entityManager->flush();
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
