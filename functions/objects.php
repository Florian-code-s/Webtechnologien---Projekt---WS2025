<?php
class LessonResult {
    public $name;
    public $date;
    public function __construct($name, $date) {
        $this->name = $name;
        $this->date = $date;
    }
}

class Lesson {
    public $name;
    public function __construct($name) {
        $this->name = $name;
    }
}
?>