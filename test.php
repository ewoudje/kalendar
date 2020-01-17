<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/client.php';

// Get the API client and construct the service object.
$client = getClient(1);

$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
$calendarId = 'primary';
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);
$results = $service->calendarList->listCalendarList();
$events = $results->getItems();

if (empty($events)) {
  print "No upcoming events found.\n";
} else {
  print "Upcoming events:\n";
  foreach ($events as $event) {
      printf("<p>%s</p>", $event->getSummary());
  }
}
