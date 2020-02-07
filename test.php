<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/client.php';

use \Firebase\JWT\JWT;

$client = new Google_Client();
$client->setAuthConfig('credentials.json');

if (isset($_GET['code'])) {

  $decoded = (array) JWT::decode($_GET['code'], $client->getClientSecret(), array('HS256'));

  $week = date_create($decoded["date"]);
} else { die; }

$client = getClient($decoded["campaign"]);

$service = new Google_Service_Calendar($client);

$results = $service->calendarList->listCalendarList();
$calendars = $results->getItems();

$s_length = strlen('Kalendar');

if (empty($calendars)) {
  print "Geen agenda gevonden!\n";
} else {
  echo $decoded["user"];
  foreach ($calendars as $calendar) {
    if (substr($calendar->getSummary(), -$s_length) === 'Kalendar') {
      printf("<h2>%s</h2>", substr($calendar->getSummary(), 0, -$s_length));
      include __DIR__ . '/event_list.php';
    }
  }
}
