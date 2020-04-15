<?php

class MedCalendar
{
	//function for defining all date variables
    function MedCalendar($strDate)
    {
        if(empty($strDate)) $strDate = time();
        define('NUM_OF_DAYS', date('t',$strDate));
        define('CURRENT_DAY', date('j',$strDate));
        define('CURRENT_MONTH_C', date('F',$strDate));
        define('CURRENT_MONTH_N', date('n',$strDate));
        define('CURRENT_YEAR', date('Y',$strDate));
        define('START_DAY', date('N', mktime(0,0,0,CURRENT_MONTH_N,1, CURRENT_YEAR)) - 1); 	//to give spaces before first day of month
        define('COLUMNS', 7);
        define('PREV_MONTH', $this->PreviousMonth());
		define('PREV_YEAR', $this->PreviousYear());
        define('NEXT_MONTH', $this->NextMonth());
		define('NEXT_YEAR', $this->NextYear());
		define('SELECTED', mktime(0,0,0,$_GET['month'],1,$_GET['year']));
    }
	//function returns previous month Calendar as output
    function PreviousMonth()
    {
        return mktime(0,0,0,
                     (CURRENT_MONTH_N == 1?12:CURRENT_MONTH_N - 1),
                     (CURRENT_DAY),
                     (CURRENT_MONTH_N == 1?CURRENT_YEAR-1:CURRENT_YEAR));
    }
	//function returns next month Calendar as output
    function NextMonth()
    {
        return mktime(0,0,0,
                     (CURRENT_MONTH_N == 12?1:CURRENT_MONTH_N+1),
                     (CURRENT_DAY),
                     (CURRENT_MONTH_N == 12?CURRENT_YEAR+1:CURRENT_YEAR));
    }
	//function returns previous year Calendar as output
	function PreviousYear(){
		return mktime(0,0,0, 
                     (CURRENT_MONTH_N),
                     (CURRENT_DAY),
                     (CURRENT_YEAR - 1));
	}
	//function returns next year Calendar as output
	function NextYear(){
		return mktime(0,0,0,
                     (CURRENT_MONTH_N),
                     (CURRENT_DAY),
                     (CURRENT_YEAR + 1));
	}
	//function to print Calendar as table format
    function printCalendar()
    {
		$intMonths = array('','January','February','March','April','May','June','July','August','September','October','November','December');
		$intStartYear = date("Y")-48;
		$intEndYear= date("Y")+48;
        echo '<table>';
		echo '<form name="fr_calendar" id="fr_calendar" action="?date='.SELECTED.'" method="get">';
		echo '<tr>';
		echo '<td>';
		//dropdown to select month
		echo '<select name="month" id="month" value="month">';
			for($intJ=1;$intJ<=12;$intJ++)
			{
				echo "<option value='".$intJ."'>".$intMonths[$intJ]."</option>";
			}
		echo '</select>';
		echo '</td>';
		echo '<td>';
		//dropdown to select year
		echo '<select name="year" id="year" value="month">';
			for($intK=$intStartYear;$intK<=$intEndYear;$intK++)
			{
				echo "<option value='$intK'>$intK</option>";
			}
		echo '</select>';
		echo '</td>';
		echo '<td>';
		echo '<input type="submit" value="Go"/>';
		//echo '<a style = "text-decoration: none;" href="?date='.SELECTED.'">GO</a>';
		echo '</td>';
		echo '</tr>';
		echo '</form>';
		echo '</table>';
		echo '<table border="1" cellspacing="4" style="border-collapse:collapse;">';
        echo '<tr><td colspan="7" style="text-align:center">'.CURRENT_MONTH_C .' - '. CURRENT_YEAR.'</td></tr>';
        echo '<tr>';
		echo '<td width="20"><a style = "text-decoration: none;" href="?date='.PREV_YEAR.'"><<</a></td>';
        echo '<td width="20"><a style = "text-decoration: none;" href="?date='.PREV_MONTH.'"><</a></td>';       
        echo '<td colspan="3" style="text-align:center"><a style = "text-decoration: none;" href="?date='.mktime(0,0,0,date('n'),date('d'),date('Y')).'">Today</a></td>';
        echo '<td width="20"><a style = "text-decoration: none;" href="?date='.NEXT_MONTH.'">></a></td>';
        echo '<td width="20"><a style = "text-decoration: none;" href="?date='.NEXT_YEAR.'">>></a></td>';
        echo '</tr><tr>';
        echo '<td width="30">Mon</td>';
        echo '<td width="30">Tue</td>';
        echo '<td width="30">Wed</td>';
        echo '<td width="30">Thu</td>';
        echo '<td width="30">Fri</td>';
        echo '<td width="30">Sat</td>';
        echo '<td width="30">Sun</td>';
        echo '</tr><tr>';
        echo str_repeat('<td> </td>', START_DAY);
		//no. of rows to print for all days of month
        $intRows = 1;
		//prints no. of days of each month
        for($intI = 1; $intI <= NUM_OF_DAYS; $intI++)
        {
				if($intI == CURRENT_DAY){
					echo '<td id="today" style="background-color: lightgray"><strong>'.$intI.'</strong></td>';
				}
				else{
					echo '<td>'.$intI.'</a></td>';
				}
                if((($intI + START_DAY) % COLUMNS) == 0 && $intI != NUM_OF_DAYS)
				{
					echo '</tr><tr>';
					$intRows++;
				}
        }
        echo '</tr></table>';
    }
}
$objCal = new MedCalendar($_GET['date']);
$objCal->printCalendar();
