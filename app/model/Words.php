<?php
    namespace project\model;

    include_once __DIR__ . '/abstract/iWords.php';

    class Words implements iWords {
        public function getWords(): array {

        }

        public function init(): void {
            $mysql = new \mysqli('localhost', 'root', 'KisaragiEki4');
            $mysql->query("CREATE DATABASE IF NOT EXISTS Words");
            $mysql->close();
        }
    }