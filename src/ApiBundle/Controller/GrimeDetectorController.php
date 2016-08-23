<?php

namespace ApiBundle\Controller;

use ApiBundle\Form\Type\QueryType;
use ApiBundle\Model\Query;
use GrimeDetectorBundle\Corrector\GrimeCorrector;
use GrimeDetectorBundle\Detector\StrategyFactory;
use GrimeDetectorBundle\Service\StatusService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class GrimeDetectorController extends BaseController
{
    /**
     * @ApiDoc(
     *  description="Returns API status"
     * )
     * @return Response
     */
    public function statusAction()
    {
        /** @var StatusService $statusService */
        $statusService = $this->get('grime_detector.service.status_service');

        $data = [
            'languages' => $statusService->getLanguagesCount(),
            'checked' => $statusService->getCheckedTextCount(),
            'grime' => $statusService->getGrimeFoundCount()
        ];

        return JsonResponse::create($data, Response::HTTP_OK);
    }

    /**
     * @ApiDoc(
     *  description="Returns the result of the text analysis",
     *  requirements={
     *      {
     *          "name"="text",
     *          "dataType"="String",
     *          "requirement"="true",
     *          "description"="Text to check"
     *      },
     *      {
     *          "name"="language",
     *          "dataType"="String",
     *          "requirement"="false",
     *          "description"="Specify language to use, default check in all languages"
     *      },
     *      {
     *          "name"="correct",
     *          "dataType"="Boolean",
     *          "requirement"="false",
     *          "description"="If true, replace grime words"
     *      }
     *  }
     * )
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

        /** @var StrategyFactory $strategyFactory */
        $strategyFactory = $this->get('grime_detector.detector.strategy_factory');
        $strategy = $strategyFactory->getStrategy('static');

        $result = $strategy->check($query->text, $query->language);

        if ($result) {
            return JsonResponse::create([
                'STATUS' => 'OK'
            ], Response::HTTP_OK);
        }

        if ($query->correct) {
            /** @var GrimeCorrector $grimeCorrector */
            $grimeCorrector = $this->get('grime_detector.corrector.grime_corrector');
            $correctText = $grimeCorrector->correct($query->text, $query->language);

            return JsonResponse::create([
                'STATUS' => 'GRIME',
                'CORRECT' => $correctText
            ], Response::HTTP_OK);
        }

        return JsonResponse::create([
            'STATUS' => 'GRIME'
        ], Response::HTTP_OK);
    }
}
