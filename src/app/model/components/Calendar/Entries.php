<?php
    namespace project\model;

    require_once __DIR__ . '/Entries/Entry.php';

    class Entries {
        public int $last_ID;

        private array $array_entries;

        public function __construct(object $entries_data, string $userName) {
            $this->setAllEntries($entries_data);
            $this->setLastID($userName);
        }

        public function getEntriesOfDay(\DateTimeImmutable $day): array|null {
            $key = 'date_' . $day->format('o_n_j');
            $validation = array_key_exists($key, $this->array_entries);
            if($validation) return $this->array_entries[$key];
            else return null;
        }

        public function getLastID($userName): int {
            $this->setLastID($userName);
            return $this->last_ID;
        }





        private function setAllEntries(object $entries_data) {
            $this->array_entries = [];
            $entry_date = false;
            $entry;

            foreach($entries_data as $row) {
                $entry = new Entry($row);
                $entry_date = 'date_' . $entry->getTimelabel();

                if(array_key_exists($entry_date, $this->array_entries)) {
                    $this->array_entries[$entry_date][] = $entry;
                }
                else {
                    $this->array_entries[$entry_date] = [];
                    $this->array_entries[$entry_date][] = $entry;
                }
            }
        }

        private function setLastID($userName): void {
            $mysql = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
            $data = $mysql->query("SELECT MAX(ID) as last_ID FROM $userName");
            foreach($data as $row) {
                if($row['last_ID']) $this->last_ID = $row['last_ID'];
                else {
                    $this->resetAutoIncrement($userName);
                    $this->last_ID = 0;
                }
            }
        }

        private function resetAutoIncrement($userName): void {
            $mysql = new \mysqli('localhost', 'Calendar', 'kISARAGIeKI4', 'Calendar');
            $mysql->query("ALTER TABLE $userName AUTO_INCREMENT = 0");
            $mysql->close();
        }
    }