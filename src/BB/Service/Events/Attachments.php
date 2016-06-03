<?php
namespace BB\Service\Events;

use BB\Service\ServiceRest;

class Attachments extends ServiceRest {

    const TYPE = 'attachments';

    public function getById($id) {
        return $this->api($id);
    }

    public function getByEventId($eventId) {
        return $this->api(null, static::METHOD_GET, [
            'event_id' => $eventId
        ]);
    }

    public function get(array $params = array()) {
        return $this->api(null, static::METHOD_GET, $params);
    }

    public function onCreateCollection() {
        return new static($this->getApiToken());
    }

    public function onCreateItem() {
        return new Attachment($this->getApiToken());
    }

}