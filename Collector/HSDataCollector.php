<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\HandlerSocketBundle\Collector;

use KonstantinKuklin\HandlerSocketBundle\HS\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class HSDataCollector extends DataCollector
{
    private $manager = null;

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

        $count = $reader->getCountQueries();
        $time = $reader->getTimeQueries();

        // check if writer configured
        if ($writer !== null) {
            $count += $writer->getCountQueries();
            $time += $writer->getTimeQueries();
        }

        $this->data = array(
            'count' => $count,
            'time' => $time
        );
    }

    /**
     * @return double
     */
    public function getTime()
    {
        return $this->data['time'];
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->data['count'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hs';
    }

    /**
     * @return Manager
     */
    private function getManager()
    {
        return $this->manager;
    }
} 