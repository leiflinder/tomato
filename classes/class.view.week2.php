<?php
class viewweek2 extends conn
{
    public $week_number_only;
    public $week_number;
    public $week_formated_like_database;

    public function week_number_only($alter=NULL)
    {
        $WeekNumber = date('W');
        $WeekNumber = $WeekNumber - $alter;
        $this->week_number = $WeekNumber;
        // format like datbase value
        $this->week_formated_like_database = date('Y')."-W".$this->week_number;
    }
}

?>