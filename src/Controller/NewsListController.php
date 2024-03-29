<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * News list controller.
 */
class NewsListController
{
    /**
     * Template engine
     *
     * @var EngineInterface
     */
    private $templateEngine;

    /**
     * News repository
     *
     * @var EntityRepository
     */
    private $newsRepository;

    /**
     * NewsListController constructor.
     *
     * @param EngineInterface  $templateEngine Template engine
     * @param EntityRepository $newsRepository News repository
     */
    public function __construct(EngineInterface $templateEngine, EntityRepository $newsRepository)
    {
        $this->templateEngine = $templateEngine;
        $this->newsRepository = $newsRepository;
    }

    /**
     * Renders news list
     *
     * @return Response
     */
    public function list(): Response
    {
        $news    = $this->newsRepository->findAll();
        $content = $this->templateEngine->render('News/list.html.twig', ['news' => $news]);

        $response = new Response($content);

        return $response;
    }
}
