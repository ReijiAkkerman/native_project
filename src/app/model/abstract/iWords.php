<?php
    namespace project\model;

    interface iWords {
        public function getWords(): array;
        public function init(): void;
    }