<?php
namespace BB\Service\Events;

use BB\Service\IServiceItem;
use Pecee\Http\Rest\RestItem;

class Attachment extends RestItem implements IServiceItem {

    public function __construct($apiToken) {
        parent::__construct(new Attachments($apiToken));
    }

}