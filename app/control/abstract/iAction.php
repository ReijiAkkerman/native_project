<?php
    namespace project\control;

    interface iAction {
       public function calendar(array|null $args = null): void;
    }