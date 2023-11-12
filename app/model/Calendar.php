<?php
    namespace project\model;

    use project\control\Auth as Auth;

    include_once __DIR__ . '/abstract/iCalendar.php';
    include_once __DIR__ . '/components/Calendar/Entries.php';

    class Calendar implements iCalendar {
        public Entries $entries;
        private string $userName;





        public function __construct(int $start_timelabel = null, int $end_timelabel = null) {
            $this->setProperties();
            if($start_timelabel && $end_timelabel) $this->setEntries($start_timelabel, $end_timelabel);
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
            echo "{
                \"className\": \"date_{$_POST['start_year']}_{$_POST['start_month']}_{$_POST['start_day']}\",
                \"title\": \"{$_POST['title']}\"
            }";
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





        private function setEntries(int $start_timelabel, int $end_timelabel): void {
            $mysql = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
            $entries_data = $mysql->query("SELECT * FROM {$this->userName}");
            $this->entries = new Entries($entries_data, $start_timelabel, $end_timelabel);
        }

        private function setProperties(): void {
            $this->userName = (new Auth)->getUser();
        }
    }