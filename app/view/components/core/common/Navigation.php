<?php
    namespace project\view\components;

    use project\core\Router;

    require_once __DIR__ . '/abstract/iNavigation.php';

    class Navigation implements iNavigation{
        private array $order;
        private array $files;

        public function __construct() {
            $this->order = [
                'main',
                'calendar',
                'words'
            ];
            $this->files = array_diff(scandir(__DIR__ . '/../../common_Navigation', SCANDIR_SORT_NONE), ['..', '.']);
        }

        public function paste(): void {
            foreach($this->files as $key => $value) {
                if(!in_array(substr($value, 0, -4), $this->order)) {
                    $this->order[] = substr($value, 0, -4);
                }
            }
            for($i = 0; $i < sizeof($this->order); $i++) {
                if($this->order[$i] != (new Router)->URI[2]) {
                    include __DIR__ . '/../../common_Navigation/' . $this->order[$i] . '.php';
                }
            }
        }
    }