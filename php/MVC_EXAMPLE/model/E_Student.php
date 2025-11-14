<?php
    class Entity_Student {
        public $id;
        public $name;
        public $age;
        public $university;

        public function __construct($id, $name, $age, $university) {
            $this->id = $id;
            $this->name = $name;
            $this->age = $age;
            $this->university = $university;
        }

        // Getter methods
        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function getAge() {
            return $this->age;
        }

        public function getUniversity() {
            return $this->university;
        }
    }
?>