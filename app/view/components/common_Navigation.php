<?php 
    use project\view\components\Navigation as Navigation;

    include_once __DIR__ . '/core/common/Navigation.php';
?>
<section class="common_Navigation">
    <nav class="common_NavigationMain">
        <?php (new Navigation)->paste() ?>
    </nav>
</section>