<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\NewsRecord;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * News show controller.
 */
class NewsShowController
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
     * NewsShowController constructor.
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
     * Renders a target news record
     *
     * @param NewsRecord $newsRecord News record
     *
     * @return Response
     *
     * @ParamConverter(name="newsRecord", converter="doctrine.orm", options={"mapping"={"slug": "title"}})
     */
    // slug is just a title here. but you can use Sluggable thing if you want so)
    public function show(NewsRecord $newsRecord): Response
    {
        $content = $this->templateEngine->render('News/_item.html.twig', ['newsRecord' => $newsRecord]);

        $response = new Response($content);

        return $response;
    }
}
