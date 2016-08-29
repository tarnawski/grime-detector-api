<?php

namespace Tarnawski\GrimeDetectorBundle\Normalizer;

class NormalizerFactory
{
    const LOWERCASE = 'LOWERCASE';
    const STOP_WORDS = 'STOP_WORDS';
    const UNIQUE = 'UNIQUE';

    /** @var LowercaseNormalizer */
    private $lowercaseNormalizer;

    /** @var StopWordsNormalizer */
    private $stopWordsNormalizer;

    /** @var UniqueNormalizer */
    private $uniqueNormalizer;

    public function __construct(
        LowercaseNormalizer $lowercaseNormalizer,
        StopWordsNormalizer $stopWordsNormalizer,
        UniqueNormalizer $uniqueNormalizer
    ) {
        $this->lowercaseNormalizer = $lowercaseNormalizer;
        $this->stopWordsNormalizer = $stopWordsNormalizer;
        $this->uniqueNormalizer = $uniqueNormalizer;
    }

    /**
     * @param array $arrayWords
     * @param array $types
     * @return array
     */
    public function normalize($arrayWords, $types)
    {
        if (in_array(self::LOWERCASE, $types)) {
            $arrayWords = $this->lowercaseNormalizer->normalize($arrayWords);
        }
        if (in_array(self::STOP_WORDS, $types)) {
            $arrayWords = $this->stopWordsNormalizer->normalize($arrayWords);
        }
        if (in_array(self::UNIQUE, $types)) {
            $arrayWords = $this->uniqueNormalizer->normalize($arrayWords);
        }

        return $arrayWords;
    }
}
