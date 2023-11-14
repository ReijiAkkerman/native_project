<?php
    namespace project\view;

    use project\model\Calendar as model_Calendar;
    use project\model\Entries as Entries;

    include_once __DIR__ . '/abstract/iCalendar.php';
    include_once __DIR__ . '/../../model/Calendar.php';
    include_once __DIR__ . '/../../model/components/Calendar/Entries.php';

    class Calendar implements iCalendar {
        public \DateTimeImmutable $current_day;
        public \DateTimeImmutable $days_counter;
        public \DateInterval $date_range;
        public \DateInterval $days_counter_interval;

        private \DateTimeImmutable $start_day;
        private \DateTimeImmutable $end_day;
        private \DateInterval $calendar_interval;

        private model_Calendar $calendar;

        public function __construct() {
            $this->setDefaults();
        }

        public function pasteEntries(): void {
            $entries = $this->calendar->entries->getEntriesOfDay($this->days_counter);
            if($entries) {
                for($i = 0; $i < sizeof($entries); $i++) {
                    include __DIR__ . '/../components/calendar_CalendarBodyDay/button.php';
                }
            }
        }

        public function createCalendar(): void {
            for($i = 0; $i <= $this->date_range->days; $i++) {
                include __DIR__ . '/../components/calendar_CalendarBodyDay.php';
                $this->days_counter = $this->days_counter->add($this->days_counter_interval);
            }
        }





        private function setDefaults(): void {
            $this->current_day = new \DateTimeImmutable();
            $this->days_counter_interval = new \DateInterval('P1D');
            $this->calendar_interval = new \DateInterval('P3M');
            $this->start_day = $this->current_day->sub($this->calendar_interval);
            $this->end_day = $this->current_day->add($this->calendar_interval);
            $start_weekday = (int)$this->start_day->format('w');
            $end_weekday = 6 - (int)$this->end_day->format('w');
            if($start_weekday) $this->start_day = $this->start_day->sub((new \DateInterval('P' . $start_weekday . 'D')));
            if($end_weekday) $this->end_day = $this->end_day->add((new \DateInterval('P' . $end_weekday . 'D')));
            $this->days_counter = clone $this->start_day;
            $this->date_range = $this->end_day->diff($this->start_day);

            $this->calendar = new model_Calendar($this->start_day->getTimestamp(), $this->end_day->getTimestamp());
        }
    }