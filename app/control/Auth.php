<?php
    namespace project\control;

    include_once __DIR__ . '/abstract/iAuth.php';

    class Auth implements iAuth {
        public bool $access;

        protected string $login;
        protected string $password_hash;
        protected string $name;
        protected string $email;

        public function __construct() {
            if(isset($_POST['login'])) $this->login = $_POST['login'];
            if(isset($_POST['name'])) $this->name = $_POST['name'];
            if(isset($_POST['email'])) $this->email = $_POST['email'];
            if(isset($_POST['password'])) $this->encryptPassword($_POST['password']);
            isset($_COOKIE['id']) && isset($_COOKIE['confirming']) ? $this->access = true : $this->access = false;
        }





        public function login(): bool {
            $data;
            $password;
            $id;

            try {
                $mysql = new \mysqli('localhost', 'User', 'kISARAGIeKI4', 'User');
                $data = $mysql->query("SELECT * FROM user WHERE login = '{$this->login}'");
                foreach($data as $row) {
                    $password = $row['password'];
                    $id = $row['ID'];
                }
                if(password_verify(bin2hex($_POST['password']), $password)) {
                    setcookie('id', $id, time() + (3600 * 24 * 30), '/');
                    setcookie('confirming', $password, time() + (3600 * 24 * 30), '/');
                    
                    header('Location: ../view/main');
                    return true;
                }
                else {
                    header('Location: ../view/error');
                    return false;
                }
            }
            catch(Trowable) {
                header('Location: ../view/error');
                return false;
            }
        }

        public function registration(): bool {
            try {
                $data;
                $id;
    
                $mysql = new \mysqli('localhost', 'User', 'kISARAGIeKI4', 'User');
                $time = time();
                $mysql->query("INSERT INTO user(
                    login,
                    password,
                    name, 
                    email,
                    registration_timestamp
                ) VALUES (
                    '{$this->login}',
                    '{$this->password_hash}',
                    '{$this->name}',
                    '{$this->email}',
                    $time
                )");
                $data = $mysql->query("SELECT ID FROM user WHERE login = '{$this->login}'");
                $mysql->close();
                
                $mysql = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
                $mysql->query("CREATE TABLE IF NOT EXISTS {$this->login} (
                    ID SERIAL,
                    title VARCHAR(255),
                    description TEXT,
                    creating_timestamp INT,
                    start_action INT,
                    end_action INT,
                    whole_day BOOLEAN,
                )");
                $mysql->close();

                $mysql = new \mysqli('localhost', 'Words', 'kISARAGIeKI4', 'Words');
                $mysql->query("CREATE TABLE IF NOT EXISTS {$this->login} (
                    ID INT, 
                    words TEXT,
                    creating_timestamp INT
                )");
                $mysql->close();

                foreach($data as $row) {
                    $id = (string) $row['ID'];
                }
                setcookie('id', $id, time() + (3600 * 24 * 30), '/');
                setcookie('confirming', $this->password_hash, time() + (3600 * 24 * 30), '/');
                
                header('Location: ../view/main');
                return true;
            }
            catch(Throwable) {
                header('Location: ../view/error');
                return false;
            }
        }

        public function logout(): void {
            setcookie('id', '', time() - 1, '/');
            setcookie('confirming', '', time() - 1, '/');
            header('Location: ../view/main');
        }

        public function validation(): bool {
            $data;

            if(isset($_COOKIE['id']) && isset($_COOKIE['confirming'])) {
                $mysql = new \mysqli('localhost', 'User', 'kISARAGIeKI4', 'User');
                $data = $mysql->query("SELECT * FROM user WHERE ID = {$_COOKIE['id']}");
                foreach($data as $row) {
                    if($row['password'] == $_COOKIE['confirming']) return true;
                    else return false;
                }
            }
            else return false;
        }

        public function getUser(): string {
            $mysql = new \mysqli('localhost', 'User', 'kISARAGIeKI4', 'User');
            $data = $mysql->query("SELECT login FROM user WHERE ID = {$_COOKIE['id']}");
            foreach($data as $row) {
                return $row['login'];
            }
        }





        public function init(): void {
            $mysql = new \mysqli('localhost', 'root', 'KisaragiEki4');
            $mysql->query("CREATE DATABASE IF NOT EXISTS User");
            $mysql->query("USE User");
            $mysql->query("CREATE TABLE IF NOT EXISTS user (
                ID SERIAL,
                login VARCHAR(255),
                password VARCHAR(255),
                name VARCHAR(255),
                email VARCHAR(255),
                registration_timestamp INT,
                UNIQUE (login),
                UNIQUE (email)
                )
            ");
            $mysql->query("CREATE USER 'User'@'localhost' IDENTIFIED BY 'kISARAGIeKI4'");
            $mysql->query("GRANT SELECT, INSERT, UPDATE ON User.user TO 'User'@'localhost'");
            $mysql->query("FLUSH PRIVILEGES");

            $mysql->query("CREATE USER 'Calendar'@'localhost' IDENTIFIED BY 'kISARAGIeKI4'");
            $mysql->query("GRANT SELECT, INSERT, UPDATE, CREATE ON Calendar.* TO 'Calendar'@'localhost'");
            $mysql->query("FLUSH PRIVILEGES");

            $mysql->query("CREATE USER 'Words'@'localhost' IDENTIFIED BY 'kISARAGIeKI4'");
            $mysql->query("GRANT SELECT, INSERT, UPDATE, CREATE ON Words.* TO 'Words'@'localhost'");
            $mysql->query("FLUSH PRIVILEGES");

            $mysql->close();
        }

        public function drop(): void {
            $mysql = new \mysqli('localhost', 'root', 'KisaragiEki4');

            $mysql->query("DROP DATABASE IF EXISTS User");
            $mysql->query("DROP USER 'User'@'localhost'");

            $mysql->query("DROP DATABASE IF EXISTS Calendar");
            $mysql->query("DROP USER 'Calendar'@'localhost'");

            $mysql->query("DROP DATABASE IF EXISTS Words");
            $mysql->query("DROP USER 'Words'@'localhost'");

            $mysql->close();
        }





        protected function encryptPassword(string $password) {
            $this->password_hash = bin2hex($password);
            $this->password_hash = password_hash($this->password_hash, PASSWORD_DEFAULT);
        }
    }