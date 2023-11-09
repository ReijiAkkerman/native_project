<?php
    namespace project\control;

    interface iView {
        public function login(): void;
        public function registration(): void;

        public function main(): void;
        public function calendar(): void;
        public function words(): void;

        public function error(): void;
    }