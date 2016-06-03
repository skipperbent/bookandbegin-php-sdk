<?php
namespace BB\Service\Events;

use BB\Service\ServiceRest;

class Events extends ServiceRest {

    const TYPE = 'events';

    public function getById($id) {
        return $this->api($id);
    }

    public function get($startDate, $endDate, array $params = array()) {
        return $this->api(null, static::METHOD_GET, array_merge([
            'start_date' => $startDate,
            'end_date' => $endDate
        ], $params));
    }

    public function getBookable($startDate = null, $endDate = null, array $params = array()) {
        return $this->api('/bookable', static::METHOD_GET, array_merge([
            'start_date' => $startDate,
            'end_date' => $endDate
        ], $params));
    }

    public function onCreateCollection() {
        return new static($this->getIdentifier(), $this->getApiToken());
    }

    public function onCreateItem() {
        return new Event($this->getIdentifier(), $this->getApiToken());
    }

}