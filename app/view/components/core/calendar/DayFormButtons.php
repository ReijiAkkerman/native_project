<?php
    namespace project\view\components;

    include_once __DIR__ . '/abstract/iDayFormButtons.php';

    class DayFormButtons implements iDayFormButtons {
        private array $order;
        private array $files;

        public function __construct() {
            $this->order();
        }

        public function paste(): void {
            for($i = 0; $i < sizeof($this->files); $i++) {
                if(!in_array(substr($this->files[$i], 0, -4), $this->order)) {
                    $this->order[] = substr($this->files[$i], 0, -4);
                }
            }
            for($i = 0; $i < sizeof($this->order); $i++) {
                if($this->order[$i]) {
                    include __DIR__ . '/../../calendar_DayFormButtons/' . $this->order[$i] . '.php';
                }
            }
        }

        private function order() {
            $this->files = array_diff(scandir(__DIR__ . '/../../calendar_DayFormButtons', SCANDIR_SORT_NONE), ['..', '.']);
            $this->order = [
                'save'
            ];
        }
    }