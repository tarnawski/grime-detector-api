<?php

namespace Tarnawski\GrimeDetectorBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tarnawski\GrimeDetectorBundle\Processor\CommentProcessor;
use Tarnawski\GrimeDetectorBundle\Entity\Comment;
use Tarnawski\GrimeDetectorBundle\Repository\CommentRepository;

class ProcessDataCommand extends ContainerAwareCommand
{
    const NUMBER = 1;

    protected function configure()
    {
        $this->setName('data:process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var CommentProcessor $processor */
        $processor = $this->getContainer()->get('tarnawski.grime_detector.processor.comment_processor');
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        /** @var CommentRepository $commentRepository */
        $commentRepository = $em->getRepository(Comment::class);
        $count = $commentRepository->getCountUnprocessedComments();
        $progress = new ProgressBar($output, $count);
        $progress->start();

        for ($i = 1; $i <= $count; $i += self::NUMBER) {
            $comments = $commentRepository->getUnprocessedComments(self::NUMBER);
            /** @var Comment $comment */
            foreach ($comments as $comment) {
                $result = $processor->process($comment);
                if ($result) {
                    $comment->setProcessed(true);
                    $em->persist($comment);
                    $em->flush();
                }
            }

            $progress->advance(self::NUMBER);
        }

        $progress->finish();

        $output->writeln("Finish");
    }
}
