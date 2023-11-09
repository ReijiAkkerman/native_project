<?php
    namespace project\view\components;

    use project\core\Router as Router;

    include __DIR__ . '/abstract/iHeader.php';

    class Header implements iHeader{
        private array $default_files;
        private array $defaults_order;

        private array $specific_files;
        private array $specifics_order;





        public function paste(): void {
            $this->paste_specifics();
            $this->paste_defaults();
        }





        private function paste_defaults(): void {
            $this->order_for_defaults();
            for($i = 0; $i < sizeof($this->default_files); $i++) {
                if(!in_array(substr($this->default_files[$i], 0, -4), $this->defaults_order)) {
                    $this->defaults_order[] = substr($this->default_files[$i], 0, -4);
                }
            }
            for($i = 0; $i < sizeof($this->defaults_order); $i++) {
                if($this->defaults_order[$i]) {
                    include __DIR__ . '/../../header/defaults/' . $this->defaults_order[$i] . '.php';
                }
            }
        }

        private function paste_specifics(): void {
            $method = 'order_for_' . (new Router)->URI[2];
            if(method_exists($this, $method)) {
                $this->$method();
                for($i = 0; $i < sizeof($this->specific_files); $i++) {
                    if(!in_array(substr($this->specific_files[$i], 0, -4), $this->specifics_order)) {
                        $this->specifics_order[] = substr($this->specific_files[$i], 0, -4);
                    }
                }
                for($i = 0; $i < sizeof($this->specifics_order); $i++) {
                    if($this->specifics_order[$i]) {
                        include __DIR__ . '/../../header/' . (new Router)->URI[2] . '/' . $this->specifics_order[$i] . '.php';
                    }
                }
            }
        }





        private function order_for_defaults(): void {
            $this->default_files = array_diff(scandir(__DIR__ . '/../../header/defaults', SCANDIR_SORT_NONE), ['..', '.']);
            $this->defaults_order = [
                'synchronize',
                'logout'
            ];
        }

        private function order_for_words(): void {
            $this->specific_files = array_diff(scandir(__DIR__ . '/../../header/words', SCANDIR_SORT_NONE), ['..', '.']);
            $this->specifics_order = [
                'shuffle',
                'upload'
            ];
        }

        private function order_for_calendar(): void {
            $this->specific_files = array_diff(scandir(__DIR__ . '/../../header/calendar', SCANDIR_SORT_NONE), ['..', '.']);
            $this->specifics_order = [];
        }
    }