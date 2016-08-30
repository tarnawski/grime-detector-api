<?php

namespace Tarnawski\ApiBundle\Controller;

use Tarnawski\GrimeDetectorBundle\Classifier\NaiveBayesClassifier;
use Tarnawski\GrimeDetectorBundle\Normalizer\NormalizerFactory;
use Tarnawski\GrimeDetectorBundle\Service\StatisticService;
use Tarnawski\GrimeDetectorBundle\Tokenizer\WordTokenizer;
use Tarnawski\ApiBundle\Form\Type\QueryType;
use Tarnawski\ApiBundle\Model\Query;
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
        /** @var StatisticService $statisticService */
        $statisticService = $this->get('tarnawski.grime_detector.service.statistic_service');
        $data = [
            'checked' => $statisticService->getStatistic('TEXT_CHECKED'),
            'training_data' => $statisticService->getStatistic('LEARNING_DATA'),
            'efficiency' => $statisticService->getStatistic('EFFICIENCY')
        ];
        return JsonResponse::create($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function checkAction(Request $request)
    {
        /** @var StatisticService $statisticService */
        $statisticService = $this->get('tarnawski.grime_detector.service.statistic_service');
        $statisticService->incrementStatistic('TEXT_CHECKED');

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

        /** @var NaiveBayesClassifier $classifier */
        $classifier = $this->get('tarnawski.grime_detector.naive_bayes_classifier');
        $probability = $classifier->classify($arrayWords);

        $threshold = isset($query->threshold) ? $query->threshold : $this->getParameter('default_threshold');
        $status = ($probability > $threshold) ? 'GRIME' : 'HAM';

        if ($query->output == 'complex') {
            return JsonResponse::create([
                'text' => $query->text,
                'probability' => $probability,
                'threshold' => $threshold,
                'status' => $status
            ], Response::HTTP_OK);
        }

        return JsonResponse::create([
            'status' => $status
        ], Response::HTTP_OK);
    }
}
