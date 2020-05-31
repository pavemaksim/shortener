<?php

namespace App\Service\ShortUrl;

use App\Entity\ShortUrl;
use Doctrine\ORM\EntityManagerInterface;

class ShortUrlService implements ShortUrlInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ShortUrlService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Creates a new ShortUrl record with shortCode being generated
     *
     * @param $shortUrlData
     */
    public function create($shortUrlData)
    {
        $this->em->persist($shortUrlData);
        $this->em->flush();
    }

    /**
     * Persists a short code for given instance
     *
     * @param ShortUrl $shortUrl
     * @param string $shortCode
     */
    public function persistShortCode(ShortUrl $shortUrl, string $shortCode)
    {
        $shortUrl->setShortCode($shortCode);

        $this->em->persist($shortUrl);
        $this->em->flush();
    }
}
