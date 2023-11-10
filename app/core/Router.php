<?php
    namespace project\core;

    // use project\control\View as View;
    // use project\control\Auth as Auth;
    // use project\control\Action as Action;

    include_once __DIR__ . '/abstract/iRouter.php';
    include_once __DIR__ . '/../control/View.php';
    include_once __DIR__ . '/../control/Auth.php';
    include_once __DIR__ . '/../control/Action.php';

    include_once __DIR__ . '/../control/Test.php';

    class Router implements iRouter {
        public array $URI;
        public string $controller;
        public string $method;
        public array $args;

        public function action(): void {
            if(isset($_COOKIE['id']) && isset($_COOKIE['confirming'])) {
                if(!$this->controller) $this->controller = 'View';
                if(!$this->method) (new $this->controller)->main();
                else $this->args ? 
                    (new $this->controller)->{$this->method}($this->args) :
                    (new $this->controller)->{$this->method}();
            }
            else if($this->controller && $this->method) $this->args ?
                (new $this->controller)->{$this->method}($this->args) :
                (new $this->controller)->{$this->method}();
            else header('Location: view/main');
        }

        public function __construct() {
            $this->getURI();
            $this->processURI();
        }

        private function getURI(): void {
            if($_GET) {
                $array = explode('?', $_SERVER['REQUEST_URI']);
                $controls = explode('/', $array[0]);
                $this->URI = $controls;
            }
            else $this->URI = explode('/', $_SERVER['REQUEST_URI']);
        }

        private function processURI(): void {
            if(!$this->URI[1]) {
                header('Location: view/login');
                exit;
            }
            $controllerPart = file_exists(__DIR__ . '/../control/' . ucfirst($this->URI[1]) . '.php') ? $this->URI[1] : 'view';
            $methodPart = method_exists('project\control\\' . ucfirst($controllerPart), $this->URI[2]) ? $this->URI[2] : 'error';
            $counterPart = count($this->URI);
            $argsPart = [];
            for($i = 3; $i < $counterPart; $i++) $argsPart[] = $this->URI[$i];

            $this->controller = !empty($controllerPart) ? 'project\control\\' . ucfirst($controllerPart) : '';
            $this->method = !empty($methodPart) ? $methodPart : '';
            $this->args = !empty($argsPart) ? $argsPart : [];
        }
    }