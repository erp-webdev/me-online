<?php include("../config.php"); ?><?php 
				$roomid = $_GET['roomid'] ? $_GET['roomid'] : 0; 

				$reservations = $main->get_reservations(0, 0, 0, 0, 0, $roomid);

				$return_array = array();
        		$event_array;

				foreach ($reservations as $key => $value) { 

		            $event_array = array();

		            $event_array['id'] = $value['reserve_id'];
		            $event_array['title'] = $main->truncate($value['reserve_eventname'], 16)."\n".$value['room_name'];
		            $event_array['start'] = date("Y-m-d H:i:s", $value['reserve_checkin']);
		            $event_array['end'] = date("Y-m-d H:i:s", $value['reserve_checkout']);
		            $event_array['allDay'] = false;
		            $event_array['textColor'] = '#333';
		            $event_array['editable'] = false;
		            $event_array['backgroundColor'] = $value['room_color'];
		            $event_array['borderColor'] = $value['room_color'];
		            $event_array['textColor'] = '#333';
		            $event_array['textColor'] = '#333';

		            array_push($return_array, $event_array);
		        }

			    echo json_encode($return_array);