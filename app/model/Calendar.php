<?php
    namespace project\model;

    use project\control\Auth as Auth;

    include_once __DIR__ . '/abstract/iCalendar.php';
    include_once __DIR__ . '/components/Calendar/Entries.php';

    class Calendar implements iCalendar {
        public Entries $entries;
        private string $userName;





        public function __construct(int $start_timelabel = null, int $end_timelabel = null) {
            $this->setProperties();
            $this->setEntries();
        }





        public function getEntry($args = null): void {
            $id = explode('_', $_GET['ID']);
            $ID = (int)$id[1];
            $mysql = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
            $data = $mysql->query("SELECT * FROM {$this->userName} WHERE ID = $ID");
            foreach($data as $row) {
                echo <<<END
                {
                    "title": "{$row['title']}",
                    "description": "{$row['description']}",
                    "start_action": {$row['start_action']},
                    "end_action": {$row['end_action']}
                }
                END;
            }
            $mysql->close();
        }

        public function createEntry($args = null): void {
            $creation_timestamp = time();
            $start_action = $this->getStartTimelabel();
            $end_action = $this->getEndTimelabel();

            $mysql = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
            $mysql->query("INSERT INTO {$this->userName}(
                    title,
                    description,
                    creating_timestamp,
                    start_action,
                    end_action,
                    whole_day
                ) VALUES (
                    '{$_POST['title']}',
                    '{$_POST['description']}',
                    $creation_timestamp,
                    $start_action,
                    $end_action,
                    0
                )");
            $mysql->close();;
            $entry_ID = $this->entries->last_ID + 1;

            echo <<<END
            {
                "className": "date_{$_POST['start_year']}_{$_POST['start_month']}_{$_POST['start_day']}",
                "title": "{$_POST['title']}",
                "id": "entry_$entry_ID"
            }
            END;
        }

        public function changeEntry($args = null): void {
            $start_action = $this->getStartTimelabel();
            $end_action = $this->getEndTimelabel();
            $mysql = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');

            $str = "UPDATE {$this->userName} SET title = '{$_POST['title']}', description = '{$_POST['description']}', start_action = $start_action, end_action = $end_action WHERE ID = {$args[1]}";

            $data = $mysql->query($str);
            $mysql->close();

            echo <<<END
            {
                "id": "entry_{$args[1]}",
                "title": "{$_POST['title']}"
            }
            END;
        }

        public function deleteEntry($args = null): void {
            $mysql = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
            $mysql->query("DELETE FROM {$this->userName} WHERE ID = {$args[1]}");
            $mysql->close();
        }

        public function init(): void {
            $mysql = new \mysqli('localhost', 'root', 'KisaragiEki4');
            $mysql->query("CREATE DATABASE IF NOT EXISTS Calendar");
            $mysql->close();
        }





        private function setEntries(): void {
            $mysql = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
            $entries_data = $mysql->query("SELECT * FROM {$this->userName}");
            $this->entries = new Entries($entries_data, $this->userName);
            setcookie('last_ID', (string)$this->entries->last_ID, time() + 3600 * 24 * 30, '/');
        }

        private function setProperties(): void {
            $this->userName = (new Auth)->getUser();
        }

        private function getStartTimelabel(): int {
            $timelabel = mktime(
                (int)$_POST['start_hour'],
                (int)$_POST['start_minute'],
                0,
                (int)$_POST['start_month'],
                (int)$_POST['start_day'],
                (int)$_POST['start_year']
            );
            return $timelabel;
        }

        private function getEndTimelabel(): int {
            $timelabel = mktime(
                (int)$_POST['end_hour'],
                (int)$_POST['end_minute'],
                0,
                (int)$_POST['end_month'],
                (int)$_POST['end_day'],
                (int)$_POST['end_year']
            );
            return $timelabel;
        }
    }