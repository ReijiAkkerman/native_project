<?php
    namespace project\model;

    use project\control\Auth as Auth;

    include_once __DIR__ . '/abstract/iCalendar.php';

    class Calendar implements iCalendar {
        private string $userName;





        public function __construct() {
            $this->setProperties();
        }





        public function createEntry(): void {
            $creation_timestamp = time();
            $start_action = mktime(
                (int)$_POST['start_hour'],
                (int)$_POST['start_minute'],
                0,
                (int)$_POST['start_month'],
                (int)$_POST['start_day'],
                (int)$_POST['start_year']
            );
            $end_action = mktime(
                (int)$_POST['end_hour'],
                (int)$_POST['end_minute'],
                0,
                (int)$_POST['end_month'],
                (int)$_POST['end_day'],
                (int)$_POST['end_year']
            );

            $entry = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
            $entry->query("INSERT INTO {$this->userName}(
                    title,
                    description,
                    creating_timestamp,
                    start_action,
                    end_action,
                    whole_day
                ) VALUES (
                    '{$_POST['title']}',
                    '{$_POST['description']}',
                    $creation_timestamp,
                    $start_action,
                    $end_action,
                    0
                )");
            $entry->close();
        }

        public function changeEntry(): void {

        }

        public function deleteEntry(): void {

        }

        public function deleteEntries(): void {
            
        }

        public function init(): void {
            $mysql = new \mysqli('localhost', 'root', 'KisaragiEki4');
            $mysql->query("CREATE DATABASE IF NOT EXISTS Calendar");
            $mysql->close();
        }





        private function setProperties(): void {
            $this->userName = (new Auth)->getUser();
        }
    }