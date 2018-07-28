<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\ORM\EntityManager;
use App\Entity\Field;
use App\Entity\Survey;

class SurveyCreateAction
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request, Response $response)
    {
        $body = json_decode($request->getParsedBody()['str']);

        $this->em->beginTransaction();

        $field = new Field();
        $field->fieldName = $body->field_name;
        $field->clientName = $body->client;
        // $field->regionCode = $body->region_code;
        $field->surveryAt = $body->date;
        // $field->userSeq =
        // $field->userName =

        $this->em->persist($field);
        $this->em->flush();

        foreach ($body->list as $data) {
            $survey = new Survey();
            $survey->fieldSeq = $field;
            $survey->surveyNumber = $data->number;
            $survey->plateName = $data->plate;
            $survey->treeNumber = $data->tree_number;
            $survey->isInstalled = $data->is_installed;
            $survey->points = json_encode($data->points);
            // $survey->picture
            $survey->latitude = $data->latitude;
            $survey->longitude = $data->longitude;

            $this->em->persist($survey);
        }
        $this->em->flush();

        $this->em->commit();

        return $response;
    }
}
