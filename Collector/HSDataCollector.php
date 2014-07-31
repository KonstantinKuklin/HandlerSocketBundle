<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\HandlerSocketBundle\Collector;

use HS\ResponseAbstract;
use KonstantinKuklin\HandlerSocketBundle\HS\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class HSDataCollector extends DataCollector
{
    private $manager = null;
    private $queriesCountError = 0;

    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $reader = $this->getManager()->getReader();
        $writer = $this->getManager()->getWriter();

        $queriesCountWriter = 0;
        $queriesCountReader = $reader->getCountQueries();
        $time = $reader->getTimeQueries();

        // check if writer configured
        if ($writer !== null) {
            $queriesCountWriter = $writer->getCountQueries();
            $time += $writer->getTimeQueries();
            $connectionList['writer'] = $writer->getUrlConnection();
        }
        $count = $queriesCountWriter + $queriesCountReader;
        $connectionList['reader'] = $reader->getUrlConnection();

        $this->data = array(
            'queriesCountReader' => $queriesCountReader,
            'queriesCountWriter' => $queriesCountWriter,
            'queriesCount' => $count,
            'totalTime' => $time,
            'responseListReader' => $this->getResponseList($reader->debugResponseList),
            'responseListWriter' => $this->getResponseList($writer->debugResponseList),
            'connectionList' => $connectionList,
            'queriesCountError' => $this->queriesCountError,
        );
    }

    /**
     * @return int
     */
    public function getQueriesCountError(){
        return $this->data['queriesCountError'];
    }

    /**
     * @return int
     */
    public function getQueriesCountReader()
    {
        return $this->data['queriesCountReader'];
    }

    /**
     * @return int
     */
    public function getqueriesCountWriter()
    {
        return $this->data['queriesCountWriter'];
    }

    /**
     * @return double
     */
    public function getTotalTime()
    {
        return $this->data['totalTime'];
    }

    /**
     * @return int
     */
    public function getQueriesCount()
    {
        return $this->data['queriesCount'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hs';
    }

    public function getConnectionList()
    {
        return $this->data['connectionList'];
    }

    /**
     * @return array
     */
    public function getResponseListReader()
    {
        return $this->data['responseListReader'];
    }

    /**
     * @return array
     */
    public function getResponseListWriter()
    {
        return $this->data['responseListWriter'];
    }

    /**
     * @param ResponseAbstract[] $responseList
     *
     * @return array
     */
    private function getResponseList($responseList)
    {
        $returnList = array();
        foreach ($responseList as $response) {

            if (!$response->isSuccessfully()) {
                $this->queriesCountError++;
            }

            $refl = new \ReflectionClass($response);
            /** @var ResponseAbstract $response */
            $returnList[] = array(
                'time' => $response->getTime(),
                'isError' => !$response->isSuccessfully(),
                'request' => $response->getRequest()->getRequestString(),
                'data' => $response->getData(),
                'type' => $refl->getShortName()
            );
        }

        return $returnList;
    }


    /**
     * @return Manager
     */
    private function getManager()
    {
        return $this->manager;
    }
} 