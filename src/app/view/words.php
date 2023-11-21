<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/components/head.php' ?>
    <body>
    <?php require_once __DIR__ . '/components/header.php' ?>
        <section class="common_Navigation">
        <?php require_once __DIR__ . '/components/common_Navigation.php' ?>
        </section>
        <main>
            <section class="words_Words">
                <div class="words_WordsSource">
                <?php for($i = 0; $i < 60; $i++) { ?>
                    <pre>some source</pre>
                <?php } ?>
                </div>
                <div class="words_WordsTranslation">
                <?php for($i = 0; $i < 60; $i++) { ?>
                    <pre>some translation</pre>
                <?php } ?>
                </div>
            </section>
        </main>
        <footer>

        </footer>
        <script src="../../js/common.js"></script>
        <script src="../../js/words.js"></script>
    </body>
</html>