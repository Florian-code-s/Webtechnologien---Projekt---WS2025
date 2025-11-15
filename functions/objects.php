<?php
class LessonResult {
    public $name;
    public $date;
    public function __construct($name, $date) {
        $this->name = $name;
        $this->date = $date;
    }
}
?>