<?php
require_once '../vendor/autoload.php';

//$service = new \BB\Service\Events\Events('C631D50C-C20E-46E1-91EF-901FCE0673AB');
//$events = $service->get('01-04-2016', '10-04-2016');

$service = new \BB\Service\Events\Attachments('02048CDD-B07D-42A2-A6DC-C55CD58032AD');
$messages = $service->getByEventId(1);

die(var_dump($messages));


/*$event = new \BB\Service\Events\Event('C631D50C-C20E-46E1-91EF-901FCE0673AB');
$event->name = 'Test';
$event->start_date = '06-04-1990 11:00';
$event->end_date = '05-04-1990 11:10';

die(var_dump($event->save()));*/