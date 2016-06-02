<?php
namespace BB\Service;

use Pecee\Http\HttpResponse;

abstract class ServiceRest extends ServiceBase implements IServiceCollection {

    protected $rows = array();

    public function setResponse(HttpResponse $response, $formattedResponse) {
        // TODO: Implement setResponse() method.
    }

    public function setRows(array $rows) {
        $this->rows = $rows;
    }

    /**
     * @return array
     */
    public function getRows() {
        return $this->rows;
    }

}