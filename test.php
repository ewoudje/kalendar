<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/client.php';

// Get the API client and construct the service object.
$client = getClient(3);

$service = new Google_Service_Calendar($client);

$results = $service->calendarList->listCalendarList();
$calendars = $results->getItems();

$s_length = strlen('Kalendar');

if (empty($calendars)) {
  print "Geen agenda gevonden!\n";
} else {
  foreach ($calendars as $calendar) {
    if (substr($calendar->getSummary(), -$s_length) === 'Kalendar') {
      printf("<h2>%s</h2>", substr($calendar->getSummary(), 0, -$s_length));
      include __DIR__ . '/event_list.php';
    }
  }
}
