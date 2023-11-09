<?php
    namespace project\control;

    use project\model\Calendar as m_Calendar;

    include_once __DIR__ . '/abstract/iView.php';
    include_once __DIR__ . '/../model/Calendar.php';
    include_once __DIR__ . '/../model/Words.php';

    class View implements iView {
        protected Auth $auth;

        public function __construct() {
            $this->auth = new Auth;
        }





        public function login(): void {
            $this->auth->access ? header('Location: ../view/main') : include __DIR__ . '/../view/login.php';
        }

        public function registration(): void {
            $this->auth->access ? header('Location: ../view/main') : include __DIR__ . '/../view/registration.php';
        }





        public function main(): void {
            $this->auth->validation() ? include __DIR__ . '/../view/main.php' : header('Location: ../view/login');
        }

        public function calendar(): void {
            $this->auth->validation() ? include __DIR__ . '/../view/calendar.php' : header('Location: ../view/login');
        }

        public function words(): void {
            $this->auth->validation() ? include __DIR__ . '/../view/words.php' : header('Location: ../view/login');
        }

        



        public function error(): void {
            include __DIR__ . '/../view/error.php';
        }

        public function test(): void {
            include __DIR__ . '/../view/test.php';
        }
    }