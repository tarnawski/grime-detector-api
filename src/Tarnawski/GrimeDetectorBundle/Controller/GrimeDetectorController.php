<?php

namespace Tarnawski\GrimeDetectorBundle\Controller;

use Tarnawski\GrimeDetector\Classifier\NaiveBayesClassifier;
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
        /** @var StatisticService $statisticService */
        $statisticService = $this->get('grime_detector.service.statistic_service');

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
        $form = $this->createForm(QueryType::class);
        $submittedData = json_decode($request->getContent(), true);
        $form->submit($submittedData);

        if (!$form->isValid()) {
            return $this->error($this->getFormErrorsAsArray($form));
        }

        /** @var Query $query */
        $query = $form->getData();

        /** @var NaiveBayesClassifier $classifier */
        $classifier = $this->get('tarnawski.grime_detector.naive_bayes_classifier');

        $result = $classifier->classify($query->text);


        return JsonResponse::create([
            'text' => $query->text,
            'probability' => $result
        ], Response::HTTP_OK);

    }
}
