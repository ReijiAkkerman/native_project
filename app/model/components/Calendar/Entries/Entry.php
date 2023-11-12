<?php
    namespace project\model;

    class Entry {
        public \DateTimeImmutable $start_action;
        public \DateTimeImmutable $end_action;
        public \DateTimeImmutable $creation_timestamp;
        public string $title;
        public string $description;

        private array $entry_data;

        public function __construct(array $entry) {
            $this->entry_data = $entry;
            $this->setStartAction();
            $this->setEndAction();
            $this->setCreationTimestamp();
            $this->setTextData();
        }

        public function getTimelabel(): string {
            return $this->start_action->format('o_n_j');
        }





        private function setStartAction(): void {
            $this->start_action = new \DateTimeImmutable(date(\DateTimeInterface::ISO8601, $this->entry_data['start_action']));
        }

        private function setEndAction(): void {
            $this->end_action = new \DateTimeImmutable(date(\DateTimeInterface::ISO8601, $this->entry_data['end_action']));
        }

        private function setCreationTimestamp(): void {
            $this->creation_timestamp = new \DateTimeImmutable(date(\DateTimeInterface::ISO8601, $this->entry_data['creating_timestamp']));
        }

        private function setTextData(): void {
            $this->title = $this->entry_data['title'];
            $this->description = $this->entry_data['description'];
        }
    }