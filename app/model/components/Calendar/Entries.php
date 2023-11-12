<?php
    namespace project\model;

    include_once __DIR__ . '/Entries/Entry.php';

    class Entries {
        private array $array_entries;

        public function __construct(object $entries_data) {
            $this->setAllEntries($entries_data);
        }

        public function &getEntriesOfDay(\DateTimeImmutable $day): array|null {
            $key = 'date_' . $day->format('o_n_j');
            return $this->array_entries[$key];
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
    }