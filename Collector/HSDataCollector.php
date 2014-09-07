<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\HandlerSocketBundle\Collector;

use HS\Result\ResultInterface;
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
            'resultListReader' => $this->getResponseList($reader->debugResultList),
            'resultListWriter' => $this->getResponseList($writer->debugResultList),
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
    public function getQueriesCountWriter()
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
    public function getResultListReader()
    {
        return $this->data['resultListReader'];
    }

    /**
     * @return array
     */
    public function getResultListWriter()
    {
        return $this->data['resultListWriter'];
    }

    /**
     * @param ResultInterface[] $responseList
     *
     * @return array
     */
    private function getResponseList($responseList)
    {
        $returnList = array();
        foreach ($responseList as $result) {

            if (!$result->isSuccessfully()) {
                $this->queriesCountError++;
            }

            $refl = new \ReflectionClass($result);

            $returnList[] = array(
                'time' => $result->getTime(),
                'isError' => !$result->isSuccessfully(),
                'query' => $result->getQuery()->getQueryString(),
                'data' => $result->getData(),
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