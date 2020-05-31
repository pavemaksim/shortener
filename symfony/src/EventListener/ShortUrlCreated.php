<?php

namespace App\EventListener;

use App\Entity\ShortUrl;
use App\Service\ShortCode\ShortCodeInterface;
use App\Service\ShortUrl\ShortUrlInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ShortUrlCreated
{
    /**
     * @var ShortUrlInterface
     */
    private $shortUrlService;

    /**
     * @var ShortCodeInterface
     */
    private $generatorService;

    /**
     * ShortUrlCreated constructor.
     * @param ShortUrlInterface $shortUrlService
     * @param ShortCodeInterface $generatorService
     */
    public function __construct(ShortUrlInterface $shortUrlService, ShortCodeInterface $generatorService)
    {
        $this->shortUrlService = $shortUrlService;
        $this->generatorService = $generatorService;
    }

    /**
     * postPersist listener
     *
     * @param ShortUrl $shortUrl
     * @param LifecycleEventArgs $event
     */
    public function postPersist(ShortUrl $shortUrl, LifecycleEventArgs $event)
    {
        $this->shortUrlService->persistShortCode(
            $shortUrl,
            $this->generatorService->generateCode(123)
        );
    }
}
