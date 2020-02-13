<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/client.php';

use \Firebase\JWT\JWT;

$client = new Google_Client();
$client->setAuthConfig('credentials.json');

if (isset($_GET['code'])) {

  $decoded = (array) JWT::decode($_GET['code'], $client->getClientSecret(), array('HS256'));

  $week = new DateTime($decoded["date"]);
  $period = new DateTime($decoded["period"]);
  if (new DateTime() > $period) {
    print "De 'event' is al gedaan!\n";
    die;
  }
} else {
  print "Oops something went wrong!\n";
  die;
}

if (isset($_GET['day']) && isset($_GET['moment']) && isset($_GET['ready']) && $_GET['ready'] == "true") {
  include __DIR__ . '/back.php';
} else {
  $client = getClient($decoded["campaign"]);

  $service = new Google_Service_Calendar($client);

  $results = $service->calendarList->listCalendarList();
  $calendars = $results->getItems();

  $s_length = strlen('Kalendar');

  if (empty($calendars)) {
    print "Oops something went wrong!\n";
  } else {
    echo $decoded["user"];
    foreach ($calendars as $calendar) {
      if (substr($calendar->getSummary(), -$s_length) === 'Kalendar') {
        printf("<h2>%s</h2>", substr($calendar->getSummary(), 0, -$s_length));
        include __DIR__ . '/event_list.php';
      }
    }
  }
}
