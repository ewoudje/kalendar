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

$client = getClient($decoded["campaign"]);

$service = new Google_Service_Calendar($client);

if (isset($_GET['day']) && isset($_GET['kalendar']) && isset($_GET['moment']) && isset($_GET['ready']) && $_GET['ready'] == "true") {
  $calendarid = $_GET['kalendar'];
  include __DIR__ . '/back.php';
} else {
  if (isset($_GET['kalendar'])) {
    $calendarid = $_GET['kalendar'];
    include __DIR__ . '/event_list.php';
  } else {
    $results = $service->calendarList->listCalendarList();
    $calendars = $results->getItems();

    $s_length = strlen('Kalendar');

    if (empty($calendars)) {
      print "Oops something went wrong!\n";
    } else {
      foreach ($calendars as $calendar) {
        if (substr($calendar->getSummary(), -$s_length) === 'Kalendar') {
          $calendarid = $calendar->getId();
          include __DIR__ . '/event_list.php';
        }
      }
    }
  }
}
