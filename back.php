<?php

$old = $service->events->get($calendarid, $_GET['moment']);

$attendees = $old->getAttendees();

$neat = new Google_Service_Calendar_EventAttendee();

$neat->setEmail($decoded["user"]);

array_push($attendees, $neat);

$old->setAttendees($attendees);

$service->events->update($calendarid, $_GET['moment'], $old);

?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>
  <h1>Geregistreerd</h1>
  <a href="/kalendar/share.php?code=<?=$_GET['code']?>">Kunt u nog op meerdere dagen?<a>
</body>
