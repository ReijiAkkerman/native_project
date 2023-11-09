<?php
    namespace project\core;

    use project\control\View as View;
    use project\control\Auth as Auth;

    include_once __DIR__ . '/abstract/iRouter.php';
    include_once __DIR__ . '/../control/View.php';
    include_once __DIR__ . '/../control/Auth.php';
    include_once __DIR__ . '/../control/Test.php';

    class Router implements iRouter {
        protected bool $is_get;
        public array $URI;
        protected string $controller;
        protected string $method;
        protected array $args;

        public function action(): void {
            if(isset($_COOKIE['id']) && isset($_COOKIE['confirming'])) {
                if(!$this->controller) $this->controller = 'View';
                if(!$this->method) (new $this->controller)->main();
                else $this->args ? 
                    (new $this->controller)->{$this->method}($this->args) :
                    (new $this->controller)->{$this->method}();
                    // (new View)->calendar();
            }
            else if($this->controller && $this->method) $this->args ?
                (new $this->controller)->{$this->method}($this->args) :
                (new $this->controller)->{$this->method}();
            else header('Location: view/main');
        }

        public function __construct() {
            $this->is_get = str_contains($_SERVER['REQUEST_URI'], '?');
            $this->getURI();
            $this->processURI();
        }

        private function getURI(): void {
            if($this->is_get) {
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