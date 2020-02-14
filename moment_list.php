<div class="moments">
  <?php foreach ($events as $event): ?>
    <div class="moment" onclick="moment('<?=$event->getId()?>')">
      <?php

        $start = $event->start->dateTime;
        if (empty($start)) {
            $start = $event->start->date;
        }

        $end = $event->end->dateTime;
        if (empty($start)) {
            $end = $event->end->date;
        }

      ?>
      <h2><?=$event->getSummary()?></h2>
      <p><?=date("G:i", strtotime($start))?> tot <?=date("G:i", strtotime($end))?></p>
    </div>
  <?php endforeach; ?>
</div>
