<?php
class MedCalendar
{
    function MedCalendar($date)
    {
        if(empty($date)) $date = time();
        define('NUM_OF_DAYS', date('t',$date));
        define('CURRENT_DAY', date('j',$date));
        define('CURRENT_MONTH_C', date('F',$date));
        define('CURRENT_MONTH_N', date('n',$date));
        define('CURRENT_YEAR', date('Y',$date));
        define('START_DAY', date('N', mktime(0,0,0,CURRENT_MONTH_N,1, CURRENT_YEAR)) - 1);
        define('COLUMNS', 7);
        define('PREV_MONTH', $this->PreviousMonth());
		define('PREV_YEAR', $this->PreviousYear());
        define('NEXT_MONTH', $this->NextMonth());
		define('NEXT_YEAR', $this->NextYear());
    }
    function PreviousMonth()
    {
        return mktime(0,0,0,
                      (CURRENT_MONTH_N == 1 ? 12 : CURRENT_MONTH_N - 1),
                      (CURRENT_DAY),
                      (CURRENT_MONTH_N == 1 ? CURRENT_YEAR - 1 : CURRENT_YEAR));
    }
    function NextMonth()
    {
        return mktime(0,0,0,
                      (CURRENT_MONTH_N == 12 ? 1 : CURRENT_MONTH_N + 1),
                      (CURRENT_DAY),
                      (CURRENT_MONTH_N == 12 ? CURRENT_YEAR + 1 : CURRENT_YEAR));
    }
	function PreviousYear(){
		return mktime(0,0,0, 
                      (CURRENT_MONTH_N),
                      (CURRENT_DAY),
                      (CURRENT_YEAR - 1));
	}
	function NextYear(){
		return mktime(0,0,0,
                      (CURRENT_MONTH_N),
                      (CURRENT_DAY),
                      (CURRENT_YEAR + 1));
	}
    function printCalendar()
    {
        echo '<table border="1" cellspacing="4">';
        echo '<tr><td colspan="7" style="text-align:center">'.CURRENT_MONTH_C .' - '. CURRENT_YEAR.'</td></tr>';
        echo '<tr>';
		echo '<td width="20"><a href="?date='.PREV_YEAR.'">&lt;&lt;</a></td>';
        echo '<td width="20"><a href="?date='.PREV_MONTH.'">&lt;&lt;</a></td>';       
        echo '<td colspan="3" style="text-align:center"><a href="?date='.TODAY.'">Today</a></td>';
        echo '<td width="20"><a href="?date='.NEXT_MONTH.'">&gt;&gt;</a></td>';
        echo '<td width="20"><a href="?date='.NEXT_YEAR.'">&gt;&gt;</a></td>';
        echo '</tr><tr>';
        echo '<td width="30">Mon</td>';
        echo '<td width="30">Tue</td>';
        echo '<td width="30">Wed</td>';
        echo '<td width="30">Thu</td>';
        echo '<td width="30">Fri</td>';
        echo '<td width="30">Sat</td>';
        echo '<td width="30">Sun</td>';
        echo '</tr><tr>';
        echo str_repeat('<td>&nbsp;</td>', START_DAY);
        $rows = 1;
        for($i = 1; $i <= NUM_OF_DAYS; $i++)
        {
                echo '<td>'.$i.'</a></td>';
                if((($i + START_DAY) % COLUMNS) == 0 && $i != NUM_OF_DAYS)
            {
                echo '</tr><tr>';
                $rows++;
            }
        }
        echo '</tr></table>';
    }
}
$cal = new MedCalendar($_GET['date']);
$cal->printCalendar();
?>