<?php

namespace Aoshido\webBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class MemoryDataCollector extends DataCollector {

    /**
     * Collects data for the given Request and Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An Exception instance
     */
    public function collect(Request $request, Response $response, \Exception $exception = null) {
        $this->data = array(
            'memory' => memory_get_peak_usage(true),
        );
    }

    public function getMemory() {
        return $this->data['memory'];
    }

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName() {
        return 'memory_collector';
    }

}
