<?php
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);

$results = $service->events->listEvents($calendar->getId(), $optParams);
$events = $results->getItems();


if (empty($events)) {
    echo "Geen momenten gevonden!\n";
} else {
    foreach ($events as $event) {
        $start = $event->start->dateTime;
        if (empty($start)) {
            $start = $event->start->date;
        }
        printf("<p>%s (%s)</p>\n", $event->getSummary(), $start);
    }
}
