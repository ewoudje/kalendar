<?php

function day($id, $service, $calendar, $week) {
  if (isset($_GET['day']) && $id == $_GET['day']) {
    $day = strtotime("+" . $id . " day", $week->getTimestamp());

    $optParams = array(
      'maxResults' => 10,
      'orderBy' => 'startTime',
      'singleEvents' => true,
      'timeMin' => date('c', $day),
      'timeMax' => date('c', strtotime("+1 day", $day)),
    );

    $results = $service->events->listEvents($calendar->getId(), $optParams);
    $events = $results->getItems();

    include __DIR__ . '/moment_list.php';
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <style>
    .days {
      display: flex;
    }

    .day {
      margin: 10px;
      background-color: green;
      flex-grow: 1;
      border-radius: 15px;
      text-align: center;
      max-height: 100px;
    }

    .day:hover {
      background-color: #229922;
    }

    .moments-holder {
      display: flex;
    }

    .moments {
      margin-top: 50px;
      flex-grow: 1;
      display: flex;
      flex-wrap: wrap;
      flex-direction: column;
      border-radius: 10px;
      border: 1px solid black;
    }

    .moment {
      margin: 10px;
      padding: 20px;
      background-color: lightblue;
      border-radius: 15px;
      text-align: center;
    }

    .moment:hover {
      background-color: #666699;
    }
  </style>
  <script type="text/javascript">
    function URL_add_parameter(url, param, value){
        var hash       = {};
        var parser     = document.createElement('a');

        parser.href    = url;

        var parameters = parser.search.split(/\?|&/);

        for(var i=0; i < parameters.length; i++) {
            if(!parameters[i])
                continue;

            var ary      = parameters[i].split('=');
            hash[ary[0]] = ary[1];
        }

        if (value == null) {
          delete hash[param];
        } else {
          hash[param] = value;
        }

        var list = [];
        Object.keys(hash).forEach(function (key) {
            list.push(key + '=' + hash[key]);
        });

        parser.search = '?' + list.join('&');
        return parser.href;
    }

    function day(i) {
      location.href = URL_add_parameter(location.href, 'day', i);
    }

    function moment(i) {
      location.href = URL_add_parameter(location.href, 'moment', i);
    }

    function ready() {
      location.href = URL_add_parameter(location.href, 'ready', 'true');
    }

    function back() {
      location.href = URL_add_parameter(location.href, 'moment', null);
    }
  </script>
</head>
<body>

  <?php if (isset($_GET['code'])): ?>
    <?php if (isset($_GET['day']) && isset($_GET['moment']) && !(isset($_GET['ready']) && $_GET['ready'] == "true")): ?>
      <div>
        <?php
          $day = strtotime("+" . $_GET['day'] . " day", $week->getTimestamp());
          $event = $service->events->get($calendar->getId(), $_GET['moment']);
          $start = $event->start->dateTime;
          if (empty($start)) {
              $start = $event->start->date;
          }
        ?>
        <h2>Bent u zeker dat u op dag <?=date("d/m", $day)?> om <?=date("G:i", strtotime($start))?> wilt komen?</h2>
        <button onclick="ready()">Ja</button>
        <button onclick="back()">Nee</button>
      </div>
    <?php else: ?>
      <div class="days">
        <div class="day"><div onclick="day(1)"><h2>Maandag <?=date("d/m", strtotime("+1 day", $week->getTimestamp()))?></h2></div><?=day(1, $service, $calendar, $week)?></div>
        <div class="day"><div onclick="day(2)"><h2>Dinsdag <?=date("d/m", strtotime("+2 day", $week->getTimestamp()))?></h2></div><?=day(2, $service, $calendar, $week)?></div>
        <div class="day"><div onclick="day(3)"><h2>Woensdag <?=date("d/m", strtotime("+3 day", $week->getTimestamp()))?></h2></div><?=day(3, $service, $calendar, $week)?></div>
        <div class="day"><div onclick="day(4)"><h2>Donderdag <?=date("d/m", strtotime("+4 day", $week->getTimestamp()))?></h2></div><?=day(4, $service, $calendar, $week)?></div>
        <div class="day"><div onclick="day(5)"><h2>Vrijdag <?=date("d/m", strtotime("+5 day", $week->getTimestamp()))?></h2></div><?=day(5, $service, $calendar, $week)?></div>
        <div class="day"><div onclick="day(6)"><h2>Zaterdag <?=date("d/m", strtotime("+6 day", $week->getTimestamp()))?></h2></div><?=day(6, $service, $calendar, $week)?></div>
        <div class="day"><div onclick="day(7)"><h2>Zondag <?=date("d/m", strtotime("+7 day", $week->getTimestamp()))?></h2></div><?=day(7, $service, $calendar, $week)?></div>
      </div>
    <?php endif; ?>
  <?php else: ?>
    <h2>You shouldn't be here</h2>
  <?php endif; ?>
</body>
</html>
