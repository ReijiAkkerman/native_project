<?php
    include "app/core/Router.php";

    (new Auth)->drop();
    (new Auth)->init();
    (new Calendar)->init();
    (new Words)->init();