<?php
    namespace project\view;

    interface iCalendar {
        public function pasteEntries(): void;
        public function createCalendar(): void;
    }