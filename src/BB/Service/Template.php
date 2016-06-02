<?php
namespace BB\Service;

use Pecee\Http\Rest\RestItem;

class Template extends RestItem implements IServiceItem {

    public function __construct($apiToken) {
        parent::__construct(new Templates($apiToken));
    }

}