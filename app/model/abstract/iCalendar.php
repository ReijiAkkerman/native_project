<?php
    namespace project\model;

    interface iCalendar {
        public function getEntry(): void;
        public function createEntry(): void;
        public function changeEntry(): void;
        public function deleteEntry(): void;
        public function deleteEntries(): void;
        public function init(): void;
    }