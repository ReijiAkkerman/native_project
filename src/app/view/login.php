<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/components/head.php' ?>
    <body class="login_Body">
    <?php require_once __DIR__ . '/components/header.php' ?>
        <main>
            <section class="login_Login">
                <form action="../auth/login" method="POST">
                    <div>
                        <h6>Логин</h6>
                        <input type="text" name="login">
                    </div>
                    <div>
                        <h6>Пароль</h6>
                        <input type="password" name="password">
                    </div>
                    <button>Войти</button>
                </form>
                <form action="../view/registration" method="POST">
                    <button>Нет аккаунта</button>
                </form>
            </section>
        </main>
        <footer>

        </footer>
    </body>
</html>