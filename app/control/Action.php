<?php
    namespace project\control;

    use project\model\Calendar as Calendar;

    include_once __DIR__ . '/abstract/iAction.php';

    class Action implements iAction {
        public function calendar(array|null $args = null): void {
            $method = $args[0];

            $calendar = new Calendar;
            $calendar->$method();
        }

        public function words() {

        }
    }