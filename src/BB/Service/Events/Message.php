<?php
namespace BB\Service\Events;

use BB\Service\IServiceItem;
use Pecee\Http\Rest\RestItem;

class Message extends RestItem implements IServiceItem {

    public function __construct($apiToken) {
        parent::__construct(new Messages($apiToken));
    }
    
}