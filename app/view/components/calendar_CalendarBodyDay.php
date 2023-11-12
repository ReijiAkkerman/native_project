<div class="calendar_CalendarBodyDay date_<?= $this->days_counter->format('o') . '_' . $this->days_counter->format('n') . '_' . $this->days_counter->format('j') ?>">
    <div class="calendar_CalendarBodyDayHeader" <?php if($this->days_counter->format('onj') == $this->current_day->format('onj')) echo 'id="current_day"' ?>>
        <button>
            <p>
                <?php
                    if($this->days_counter->format('n') == 1 && $this->days_counter->format('j') == 1) echo $this->days_counter->format('o') . '/';
                    if($this->days_counter->format('j') == 1) echo $this->days_counter->format('n') . '/';
                    echo $this->days_counter->format('j');
                ?>
            </p>
        </button>
    </div>
    <div class="calendar_CalendarBodyDayBody">
    <?php
        $this->pasteEntries()
    ?>
        <!-- <button><pre>some text</pre></button> -->
    </div>
</div>