<?php

namespace App\Controller;

use App\Entity\ShortUrl;
use App\Form\ShortUrlType;
use App\Repository\ShortUrlRepository;
use App\Service\ShortUrl\ShortUrlInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShortCodeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ShortUrlInterface
     */
    private $shortUrlService;

    /**
     * ShortCodeController constructor.
     * @param EntityManagerInterface $em
     * @param ShortUrlInterface $shortUrlService
     */
    public function __construct(EntityManagerInterface $em, ShortUrlInterface $shortUrlService)
    {
        $this->shortUrlService = $shortUrlService;
        $this->em = $em;
    }

    /**
     * Creates a new shortCode for given URL to shorten
     *
     * @Route("/shortcode/create", name="shortcode-create")
     */
    public function create(Request $request)
    {
        $shortUrl = new ShortUrl();

        $form = $this->createForm(ShortUrlType::class, $shortUrl);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->shortUrlService->create($form->getData());

            return $this->redirectToRoute('shortcode-view', ['shortCode' => $shortUrl->getShortCode()]);
        }

        return $this->render('urls/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Responds with a given shortCode
     *
     * @Route("/shortcode/{shortCode}", name="shortcode-view")
     */
    public function view(string $shortCode, ShortUrlRepository $shortUrlRepository)
    {
        $shortUrl = $shortUrlRepository->findByShortCode($shortCode);

        if (!$shortUrl) {
            throw $this->createNotFoundException();
        } else {
            return $this->render('urls/view.html.twig', [
                'shortCode' => $shortUrl->getShortCode()
            ]);
        }
    }

    /**
     * Redirects on a sourceUrl mapped by provided shortCode
     *
     * @Route("/s/{shortCode}", name="shortcode-resolve")
     */
    public function resolve(string $shortCode, ShortUrlRepository $shortUrlRepository)
    {
        $shortUrl = $shortUrlRepository->findByShortCode($shortCode);

        if (!$shortUrl) {
            throw $this->createNotFoundException();
        } else {
            return $this->redirect($shortUrl->getSourceUrl());
        }
    }
}
