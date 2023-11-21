<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/components/head.php' ?>
    <body>
    <?php require_once __DIR__ . '/components/header.php' ?>
        <main>
            <section class="registration_Registration">
                <form action="../auth/registration" method="POST">
                    <div>
                        <h6>E-mail</h6>
                        <input type="text" name="email">
                    </div>
                    <div>
                        <h6>Логин</h6>
                        <input type="text" name="login">
                    </div>
                    <div>
                        <h6>Имя</h6>
                        <input type="text" name="name">
                    </div>
                    <div>
                        <h6>Пароль</h6>
                        <input type="password">
                    </div>
                    <div>
                        <h6>Повтор</h6>
                        <input type="password" name="password">
                    </div>
                    <button>Зарегистрироваться</button>
                </form>
            </section>
        </main>
        <footer>

        </footer>
    </body>
</html>