<?php use project\core\Router as Router ?>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/position.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/fonts.css">
<?php if(file_exists(__DIR__ . '/../../../css/' . (new Router)->URI[2] . '/position.css')) { ?>
    <link rel="stylesheet" href="../../css/<?= (new Router)->URI[2] ?>/position.css">
<?php } ?>
<?php if(file_exists(__DIR__ . '/../../../css/' . (new Router)->URI[2] . '/style.css')) { ?>
    <link rel="stylesheet" href="../../css/<?= (new Router)->URI[2] ?>/style.css">
<?php } ?>
    <link rel="stylesheet" href="../../css/js_position.css">
    <link rel="stylesheet" href="../../css/js_style.css">
<?php if(file_exists(__DIR__ . '/../../../css/' . (new Router)->URI[2] . '/js_position.css')) { ?>
    <link rel="stylesheet" href="../../css/<?= (new Router)->URI[2] ?>/js_position.css">
<?php } ?>
<?php if(file_exists(__DIR__ . '/../../../css/' . (new Router)->URI[2] . '/js_style.css')) { ?>
    <link rel="stylesheet" href="../../css/<?= (new Router)->URI[2] ?>/js_style.css">
<?php } ?>
</head>