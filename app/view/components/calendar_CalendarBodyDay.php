<div class="calendar_CalendarBodyDay date_<?= $this->counter->format('o') . '_' . $this->counter->format('n') . '_' . $this->counter->format('j') ?>">
    <div class="calendar_CalendarBodyDayHeader" <?php if($this->counter->format('onj') == $this->current->format('onj')) echo 'id="current_day"' ?>>
        <button>
            <p>
                <?php
                    if($this->counter->format('n') == 1 && $this->counter->format('j') == 1) echo $this->counter->format('o') . '/';
                    if($this->counter->format('j') == 1) echo $this->counter->format('n') . '/';
                    echo $this->counter->format('j');
                ?>
            </p>
        </button>
    </div>
    <div class="calendar_CalendarBodyDayBody">
        <button><pre>some text</pre></button>
    </div>
</div>