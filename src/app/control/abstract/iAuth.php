<?php
    namespace project\control;

    interface iAuth {
        public function login(): bool;
        public function registration(): bool;
        public function logout(): void;
        public function validation(): bool;



        public function init(): void;
        public function drop(): void;
    }