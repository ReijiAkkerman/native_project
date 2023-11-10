<?php
    namespace project\control;

    use project\model\Calendar as Calendar;

    include_once __DIR__ . '/abstract/iAction.php';

    class Action implements iAction {
        private string $controller;
        private string $method;

        public function __construct() {
            global $route;
            $this->controller = ucfirst($route->method);
        }

        public function calendar($method = null) {
            $obj = new Calendar;
            $obj->{$method[0]}();
            echo "hello";
        }

        public function words() {
            (new $this->controller)->{$this->method}();
        }
    }