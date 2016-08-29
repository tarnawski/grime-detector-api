<?php

namespace Tarnawski\GrimeDetectorBundle\Controller;

use Tarnawski\GrimeDetector\Classifier\NaiveBayesClassifier;
use Tarnawski\GrimeDetector\DictionaryStore\JsonDictionaryStore;
use Tarnawski\GrimeDetector\Normalizer\NormalizerFactory;
use Tarnawski\GrimeDetector\Tokenizer\WordTokenizer;
use Tarnawski\GrimeDetectorBundle\Form\Type\QueryType;
use Tarnawski\GrimeDetectorBundle\Model\Query;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GrimeDetectorController extends BaseController
{
    /**
     * @return Response
     */
    public function pingAction()
    {
        return JsonResponse::create(['pong'], Response::HTTP_OK);
    }

    /**
     * @return Response
     */
    public function statusAction()
    {
        $data = [
            'checked' => 317,
            'training_data' => 687,
            'efficiency' => 65.8
        ];

        return JsonResponse::create($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function checkAction(Request $request)
    {
        $form = $this->createForm(QueryType::class);
        $submittedData = json_decode($request->getContent(), true);
        $form->submit($submittedData);

        if (!$form->isValid()) {
            return $this->error($this->getFormErrorsAsArray($form));
        }

        /** @var Query $query */
        $query = $form->getData();

        /** @var WordTokenizer $wordTokenizer */
        $wordTokenizer = $this->get('tarnawski.grime_detector.word_tokenizer');
        $arrayWords = $wordTokenizer->tokenize($query->text);

        /** @var NormalizerFactory $normalizer */
        $normalizer = $this->get('tarnawski.grime_detector.normalizer_factory');
        $arrayWords = $normalizer->normalize($arrayWords, ['LOWERCASE', 'STOP_WORDS', 'UNIQUE']);

        /** @var JsonDictionaryStore $jsonDictionaryStore */
        $jsonDictionaryStore = $this->get('tarnawski.grime_detector.json_dictionary_store');
        $dictionary = $jsonDictionaryStore->read();

        /** @var NaiveBayesClassifier $classifier */
        $classifier = $this->get('tarnawski.grime_detector.naive_bayes_classifier');

        $classifier->setDictionary($dictionary);
        $result = $classifier->classify($arrayWords);

        return JsonResponse::create([
            'text' => $query->text,
            'probability' => $result
        ], Response::HTTP_OK);
    }
}
