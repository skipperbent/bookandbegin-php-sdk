<?php

class EventTest extends PHPUnit_Framework_TestCase  {

    public function testDummy() {

        $events = new \BB\Service\Event\Event('DE208EA3-96CC-4BAE-8D3F-E78DD85A2987');

        die(var_dump($events));

    }

}