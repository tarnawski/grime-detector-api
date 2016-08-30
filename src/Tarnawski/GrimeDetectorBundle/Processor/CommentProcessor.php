<?php

namespace Tarnawski\GrimeDetectorBundle\Processor;

use Doctrine\ORM\EntityManager;
use Tarnawski\GrimeDetectorBundle\Entity\Comment;
use Tarnawski\GrimeDetectorBundle\Entity\Word;
use Tarnawski\GrimeDetectorBundle\Normalizer\NormalizerFactory;
use Tarnawski\GrimeDetectorBundle\Repository\WordRepository;
use Tarnawski\GrimeDetectorBundle\Tokenizer\WordTokenizer;

class CommentProcessor
{
    /** @var  EntityManager */
    private $em;

    /** @var WordRepository */
    private $wordRepository;

    /** @var WordTokenizer */
    private $wordTokenizer;

    /** @var NormalizerFactory */
    private $normalizer;


    public function __construct(
        EntityManager $entityManager,
        WordTokenizer $wordTokenizer,
        NormalizerFactory $normalizerFactory
    ) {
        $this->em = $entityManager;
        $this->wordRepository = $entityManager->getRepository(Word::class);
        $this->wordTokenizer = $wordTokenizer;
        $this->normalizer = $normalizerFactory;
    }

    public function process(Comment $comment)
    {
        $names = $this->wordTokenizer->tokenize($comment->getContent());
        $names = $this->normalizer->normalize($names, ['LOWERCASE', 'STOP_WORDS', 'UNIQUE']);

        foreach ($names as $name) {
            /** @var Word $word */
            $word = $this->wordRepository->getWordByName($name);
            if ($word) {
                if ($comment->isPositive()) {
                    $word->incrementPositive();
                } else {
                    $word->incrementNegative();
                }
            } else {
                $word = new Word();
                $word->setName($name);
                $word->setPositive($comment->isPositive());
                $word->setNegative(!$comment->isPositive());
            }

            $this->em->persist($word);
            $this->em->flush();
        }

        return true;
    }
}
