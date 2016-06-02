<?php
namespace BB\Service;

use Pecee\Http\HttpResponse;

interface IServiceCollection {

    public function setHttpResponse(HttpResponse $response, $formattedResponse);
    public function setRows(array $rows);

}