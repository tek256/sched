function schedule(){
	$start = date('Y-m-d H:i:s', strtotime("-2 days"));
	$end = date('Y-m-d H:i:s', strtotime("+28 days"));
	$today = date(strtotime('now'));
	
	$output = "";
	
	$db_con = mysqli_connect('localhost', 'username_goes_here', 'password_goes_here', 'sched');
	if(!$db_con){
		return "Unable to connect to database.";
	}
	
	$query = "SELECT * FROM events WHERE sched_time >= '" . $start . "' AND sched_time <= '" . $end . "' ORDER BY sched_time;";
	$results = mysqli_query($db_con, $query);
	
	if(mysqli_num_rows($results) > 0){
		while($row = mysqli_fetch_assoc($results)){
			$img_url = "";
			$type_id = intval($row['type_id']);
			switch($type_id){
				case 4:
					$img_url = "Each image type goes here";
					break;
				case 42:
					$img_url = "Another image link";
					break;
			}
			
			$row_date = date(strtotime($row['sched_time']));
			
			if($row_date < $today){
				$output .= "<div class='event event-past type". $row['type_id'] ."'><img src='".$img_url."'><a href='" . $row['link'] . "'><span class='event-name'>". $row['name'] . "</span></a><br><span class='event-time'>" . date("M dS, y H:i", strtotime($row['sched_time'])) . " " . $row['timezone'] . "</span></div>";
			}else{
				$output .= "<div class='event type". $row['type_id'] ."'><img src='".$img_url."'><a href='" . $row['link'] . "'><span class='event-name'>". $row['name'] . "</span></a><br><span class='event-time'>" . date("M dS, y H:i", strtotime($row['sched_time'])) . " " . $row['timezone'] . "</span></div>";
			}
		}
	}else{
		mysqli_close($db_con);
		return "<p class='none-scheduled'>No events scheduled at this time.</p>";
	}
	mysqli_close($db_con);

	return $output;
}

//Add to wordpress this way
add_shortcode('schedule', 'schedule');
