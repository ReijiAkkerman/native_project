<?php
    namespace project\model;

    include_once __DIR__ . '/abstract/iCalendar.php';

    class Calendar implements iCalendar {
        private array $start_timestamp;
        private array $end_timestamp;





        public function __construct() {

        }





        public function createEntry(): void {
            $calendar = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
            $calendar->query("");
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
    }