<?php
    use project\control\Auth as Auth;
    use project\model\Calendar as Calendar;
    use project\model\Words as Words;

    include "app/core/Router.php";

    (new Auth)->drop();
    (new Auth)->init();
    (new Calendar)->init();
    (new Words)->init();

    // ВАЖНО!!! Перед использованием файла закомментировать конструктор класса project\model\Calendar