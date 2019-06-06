<?php

declare(strict_types=1);

namespace App\Command\News;

use App\Entity\NewsRecord;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Adds a news record to the database
 *
 * Usage example:
 * ```
 * bin/console app:news:add "title" "description"
 * ```
 */
class AddCommand extends Command
{
    /**
     * News repository
     *
     * @var EntityRepository
     */
    private $newsRepository;

    /**
     * AddCommand constructor.
     *
     * @param EntityRepository $newsRepository News repository
     * @param string|null      $name           Command name
     */
    public function __construct(EntityRepository $newsRepository, ?string $name = null)
    {
        $this->newsRepository = $newsRepository;

        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Adds a news record to the database')
            ->addArgument(
                'title',
                InputArgument::OPTIONAL,
                'Title for a news record',
                "test_title"
            )
            ->addArgument(
                'text',
                InputArgument::OPTIONAL,
                'Text for a news record',
                "test_text"
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $newsRecordTitle = $input->getArgument('title');
        $newsRecordText  = $input->getArgument('text');

        $newsRecord = new NewsRecord();
        $newsRecord->setTitle($newsRecordTitle);
        $newsRecord->setText($newsRecordText);

        $now = new DateTime();
        $newsRecord->setUpdatedAt($now);

        $this->newsRepository->save($newsRecord);
    }
}
