<?php
    namespace project\view;

    include_once __DIR__ . '/abstract/iCalendar.php';

    class Calendar implements iCalendar{


        public \DateTimeImmutable $current;
        public \DateTimeImmutable $counter;

        public \DateInterval $date_range;
        public \DateInterval $counter_interval;




        
        private \DateTimeImmutable $start;
        private \DateTimeImmutable $end;
        
        private \DateInterval $calendar_interval;





        public function __construct() {
            $this->setDefaults();
        }





        public function pasteEntries(): void {
            
        }

        public function createCalendar(): void {
            for($i = 0; $i <= $this->date_range->days; $i++) {
                include __DIR__ . '/../components/calendar_CalendarBodyDay.php';
                $this->counter = $this->counter->add($this->counter_interval);
            }
        }





        private function setDefaults(): void {
            $this->current = new \DateTimeImmutable();
            $this->counter_interval = new \DateInterval('P1D');
            $this->calendar_interval = new \DateInterval('P3M');
            $this->start = $this->current->sub($this->calendar_interval);
            $this->end = $this->current->add($this->calendar_interval);
            
            $start_weekday = (int)$this->start->format('w');
            $end_weekday = 6 - (int)$this->end->format('w');

            if($start_weekday) $this->start = $this->start->sub((new \DateInterval('P' . $start_weekday . 'D')));
            if($end_weekday) $this->end = $this->end->add((new \DateInterval('P' . $end_weekday . 'D')));

            $this->counter = clone $this->start;
            $this->date_range = $this->end->diff($this->start);
        }
    }