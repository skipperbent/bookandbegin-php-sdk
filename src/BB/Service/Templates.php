<?php
namespace BB\Service;

class Templates extends ServiceRest {

    const TYPE = 'templates';

    public function getById($id) {
        return $this->api($id);
    }

    public function getByIdentifier($identifier) {
        return $this->api(null, static::METHOD_GET, [
            'identifier' => $identifier
        ]);
    }

    public function get(array $params = array()) {
        return $this->api(null, static::METHOD_GET, $params);
    }

    public function onCreateCollection() {
        return new static($this->getApiToken());
    }

    public function onCreateItem() {
        return new Template($this->getApiToken());
    }

}