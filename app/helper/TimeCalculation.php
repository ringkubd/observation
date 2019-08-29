<?php

namespace App\helper;
use App\schedule\shedulepass;
use Carbon\carbon;

class TimeCalculation {
	public function GetHourInrange($curdate, $start_time, $end_time, $working_start_time_range, $working_end_time_range, $rest_time = 0.00) {
		$rest_time = str_replace(":", '.', $rest_time);
		$rest_time = is_numeric($rest_time) ? $rest_time : 0;
		if ($start_time > $end_time || $end_time == '00:00' || $end_time == '24:00') {
			$end_time_manual = '23:59';
			$end_time = strtotime("$curdate $end_time_manual") + 60;
			// $end_date = new Carbon($curdate);
			// $actual_end_date=$end_date->addDays(1)->toDateString();
		}
		if ($working_start_time_range > $working_end_time_range || $working_end_time_range == '00:00' || $working_end_time_range == '24:00') {
			$end_time_manual = '23:59';
			$working_end_time_range = strtotime("$curdate $end_time_manual") + 60;
			// $end_date = new Carbon($curdate);
			// $actual_end_date=$end_date->addDays(1)->toDateString();;
		}
		$start_actual_time = is_int($start_time) ? $start_time : strtotime("$curdate $start_time");
		$end_actual_time = is_int($end_time) ? $end_time : strtotime("$curdate $end_time");
		$start_actual_time_range = is_int($working_start_time_range) ? $working_start_time_range : strtotime("$curdate $working_start_time_range");
		$end_actual_time_range = is_int($working_end_time_range) ? $working_end_time_range : strtotime("$curdate $working_end_time_range");
		$interval = $end_actual_time - $start_actual_time;
		$calculate_minitues = 0;
		for ($i = $start_actual_time; $i < $end_actual_time; $i = $i + 60) {
			if ($this->dateIsBetween($start_actual_time_range, $end_actual_time_range, $i)) {
				$calculate_minitues = $calculate_minitues + 1;
			}
		}
		return (float) (($calculate_minitues / 60));

	}

	public function GetHourInrangeInrest($start_time, $end_time, $working_start_time_range, $working_end_time_range, $rest_time = 0.00) {
		$curdate = '2019-01-01';
		$rest_time = str_replace(":", '.', $rest_time);
		$rest_time = is_numeric($rest_time) ? $rest_time : 0;
		if ($start_time > $end_time || $end_time == '00:00' || $end_time == '24:00') {
			$end_time_manual = '23:59';
			$end_time = strtotime("$curdate $end_time_manual") + 60;
		}
		if ($working_start_time_range > $working_end_time_range || $working_end_time_range == '00:00' || $working_end_time_range == '24:00') {
			$end_time_manual = '23:59';
			$working_end_time_range = strtotime("$curdate $end_time_manual") + 60;
			// $end_date = new Carbon($curdate);
			// $actual_end_date=$end_date->addDays(1)->toDateString();;
		}
		$start_actual_time = is_int($start_time) ? $start_time : strtotime("$curdate $start_time");
		$end_actual_time = is_int($end_time) ? $end_time : strtotime("$curdate $end_time");
		$start_actual_time_range = is_int($working_start_time_range) ? $working_start_time_range : strtotime("$curdate $working_start_time_range");
		$end_actual_time_range = is_int($working_end_time_range) ? $working_end_time_range : strtotime("$curdate $working_end_time_range");
		$interval = $end_actual_time - $start_actual_time;
		$calculate_actual_hour_range = [];
		for ($i = $start_actual_time; $i < $end_actual_time; $i = $i + 60) {
			if ($this->dateIsBetween($start_actual_time_range, $end_actual_time_range, $i)) {
				array_push($calculate_actual_hour_range, $i);
			}
		}
		if (count($calculate_actual_hour_range) > 0) {
			$max = date('H:i', max($calculate_actual_hour_range) + 60);
			$min = date('H:i', min($calculate_actual_hour_range));
			return [$min, $max, $this->CalculationWorktime($min, $max)];
		}
		return [];

	}

	public function CalculateActualStartTimeEndTimeForHolydays($curdate, $start_time, $end_time, $working_start_time_range, $working_end_time_range, $rest_time = 0.00) {
		$rest_time = str_replace(":", '.', $rest_time);
		$rest_time = is_numeric($rest_time) ? $rest_time : 0;
		if ($start_time > $end_time || $end_time == '00:00' || $end_time == '24:00') {
			$end_time_manual = '23:59';
			$end_time = strtotime("$curdate $end_time_manual") + 60;
			// $end_date = new Carbon($curdate);
			// $actual_end_date=$end_date->addDays(1)->toDateString();
		}
		if ($working_start_time_range > $working_end_time_range || $working_end_time_range == '00:00' || $working_end_time_range == '24:00') {
			$end_time_manual = '23:59';
			$working_end_time_range = strtotime("$curdate $end_time_manual") + 60;
			// $end_date = new Carbon($curdate);
			// $actual_end_date=$end_date->addDays(1)->toDateString();;
		}
		$start_actual_time = is_int($start_time) ? $start_time : strtotime("$curdate $start_time");
		$end_actual_time = is_int($end_time) ? $end_time : strtotime("$curdate $end_time");
		$start_actual_time_range = is_int($working_start_time_range) ? $working_start_time_range : strtotime("$curdate $working_start_time_range");
		$end_actual_time_range = is_int($working_end_time_range) ? $working_end_time_range : strtotime("$curdate $working_end_time_range");
		$interval = $end_actual_time - $start_actual_time;
		$calculate_range = array();
		for ($i = $start_actual_time; $i < $end_actual_time; $i = $i + 60) {
			if ($this->dateIsBetweenForRange($start_actual_time_range, $end_actual_time_range, $i)) {
				array_push($calculate_range, date("H:i", $i));
			}
		}
		return $calculate_range;

	}
	public function dateIsBetween($from, $to, $date) {
		return ($date >= $from) && ($date < $to);
	}
	public function dateIsBetweenForRange($from, $to, $date) {
		return ($date >= $from) && ($date < $to);
	}

	public function ConvertTimeTodecimalTime($string): float {
		if ($string != null) {
			if (strpos($string, ':') !== false) {
				$replace_colon = explode(':', $string);
				$fractionTime = (float) ($replace_colon[1] / 60);
				return $floatTime = $replace_colon[0] + $fractionTime;

			} else {
				return $string;
			}

		} else {
			return 0;
		}

	}

	public function GetHolydayAsWeekendWorkingHour($timeRhstart, $timeRhend, $holyday_as_weekend, $schedule) {
		$timeRhstart = $schedule->arb_pass->start_time ?? $start_time;
		$timeRhend = $schedule->arb_pass->end_time ?? $end_time;
		$date_list = explode(',', $holyday_as_weekend->datelist);
		$count_unique_holyday = count($date_list);
		if (in_array($schedule->work_date, $date_list)) {
			if ($count_unique_holyday > 0) {
				if ($date_list[0] == $schedule->work_date && $date_list[$count_unique_holyday - 1] == $schedule->work_date) {
					$holyday_starttime = $holyday_as_weekend->start_time;
					$holyday_endtime = $holyday_as_weekend->end_time;
				} elseif ($date_list[0] < $schedule->work_date && $date_list[$count_unique_holyday - 1] == $schedule->work_date) {
					$holyday_starttime = $timeRhstart;
					$holyday_endtime = $holyday_as_weekend->end_time;
					if ($holyday_starttime > $holyday_endtime) {
						$holyday_endtime = $holyday_starttime;
					}
				} elseif ($date_list[0] < $schedule->work_date && $date_list[$count_unique_holyday - 1] > $schedule->work_date) {
					$holyday_starttime = $timeRhstart;
					$holyday_endtime = $timeRhend;
				} elseif ($date_list[0] == $schedule->work_date && $date_list[$count_unique_holyday - 1] > $schedule->work_date) {
					$default_start_time = strtotime("$schedule->work_date $timeRhstart");
					$default_h_start_time = strtotime("$schedule->work_date $holyday_as_weekend->start_time");
					if ($timeRhend == '00:00') {
						$default_end_time = strtotime("$schedule->work_date 23:59") + 60;
					} else {
						$default_end_time = strtotime("$schedule->work_date $timeRhend");
					}
					$default_end_time = strtotime("$schedule->work_date $timeRhend");
					if ($default_start_time > $default_h_start_time) {
						$holyday_starttime = $timeRhstart;
					} else {
						$holyday_starttime = $holyday_as_weekend->start_time;
					}

					if ($default_end_time > strtotime("$schedule->work_date $holyday_starttime")) {

						$holyday_endtime = $timeRhend;
					} else {
						$holyday_endtime = $timeRhend;
					}

				}

				return $total_worked = $this->GetHourInrange($schedule->work_date, $timeRhstart, $timeRhend, $holyday_starttime, $holyday_endtime, 00.00);
			}
		}
	}

	public function GetHolydayColor($timeRhstart, $timeRhend, $holyday_as_weekend, $schedule) {
		$date_list = explode(',', $holyday_as_weekend->datelist);
		if (in_array($schedule->work_date, $date_list)) {
			return 10;
		}

	}

	public function GetWeekendWorkingHour($start_time, $end_time, $weekend_period, $schedule, $weekend_info) {
		$stat_time = $schedule->arb_pass->start_time ?? $start_time;
		$end_time = $schedule->arb_pass->end_time ?? $end_time;
		$count_weekend_info = count($weekend_info);
		if (strtolower(date("D", strtotime($schedule->work_date))) == $weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date))) == $weekend_info[$count_weekend_info - 1]) {
			$weekend_starttime = $weekend_period->start_time;
			$weekend_endtime = $weekend_period->end_time;
		} elseif (strtolower(date("D", strtotime($schedule->work_date))) == $weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date))) != $weekend_info[$count_weekend_info - 1]) {
			$weekend_starttime = $weekend_period->start_time;
			$weekend_endtime = $end_time;
			// if ($weekend_starttime>$weekend_endtime) {
			//    $weekend_endtime=$weekend_starttime;
			//  }
		} elseif (strtolower(date("D", strtotime($schedule->work_date))) != $weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date))) != $weekend_info[$count_weekend_info - 1]) {

			$weekend_starttime = $start_time;
			$weekend_endtime = $end_time;
		} elseif (strtolower(date("D", strtotime($schedule->work_date))) != $weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date))) == $weekend_info[$count_weekend_info - 1]) {
			$weekend_starttime = $start_time;
			$weekend_endtime = $weekend_period->end_time;
			if ($weekend_starttime > $weekend_endtime) {
				$weekend_endtime = $weekend_starttime;
			}
		}

		return $this->GetHourInrange($schedule->work_date, $start_time, $end_time, $weekend_starttime, $weekend_endtime, 00.00);

	}

	public function CalculateRestApplicableRangeInweekendRange($start_time, $end_time, $weekend_period, $schedule, $weekend_info) {
		if ($start_time == $end_time) {
			return null;}

		$count_weekend_info = count($weekend_info);
		if (strtolower(date("D", strtotime($schedule->work_date))) == $weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date))) == $weekend_info[$count_weekend_info - 1]) {
			$weekend_starttime = $weekend_period->start_time;
			$weekend_endtime = $weekend_period->end_time;
		} elseif (strtolower(date("D", strtotime($schedule->work_date))) == $weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date))) != $weekend_info[$count_weekend_info - 1]) {
			$weekend_starttime = $weekend_period->start_time;
			$weekend_endtime = $end_time;
			// if ($weekend_starttime>$weekend_endtime) {
			//    $weekend_endtime=$weekend_starttime;
			//  }
		} elseif (strtolower(date("D", strtotime($schedule->work_date))) != $weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date))) != $weekend_info[$count_weekend_info - 1]) {
			$weekend_starttime = $start_time;
			$weekend_endtime = $end_time;
		} elseif (strtolower(date("D", strtotime($schedule->work_date))) != $weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date))) == $weekend_info[$count_weekend_info - 1]) {
			$weekend_starttime = $start_time;
			$weekend_endtime = $weekend_period->end_time;
			if ($weekend_starttime > $weekend_endtime) {
				$weekend_endtime = $weekend_starttime;
			}
		}
		return $this->CalculateActualStartTimeEndTimeForHolydays($schedule->work_date, $start_time, $end_time, $weekend_starttime, $weekend_endtime, 00.00);

	}

	public function CalculateRestApplicableRangeInholydayRange($timeRhstart, $timeRhend, $holyday_as_weekend, $schedule) {
		if ($timeRhstart == $timeRhend) {
			return null;}
		$date_list = explode(',', $holyday_as_weekend->datelist);
		$count_unique_holyday = count($date_list);
		if (in_array($schedule->work_date, $date_list)) {
			if ($count_unique_holyday > 0) {
				$rest_applicable_range_in_holyday = array();
				if ($date_list[0] == $schedule->work_date && $date_list[$count_unique_holyday - 1] == $schedule->work_date) {
					$holyday_starttime = $holyday_as_weekend->start_time;
					$holyday_endtime = $holyday_as_weekend->end_time;

				} elseif ($date_list[0] < $schedule->work_date && $date_list[$count_unique_holyday - 1] == $schedule->work_date) {
					$holyday_starttime = $timeRhstart;
					$holyday_endtime = $holyday_as_weekend->end_time;
					if ($holyday_starttime > $holyday_endtime) {
						$holyday_endtime = $holyday_starttime;
					}

				} elseif ($date_list[0] < $schedule->work_date && $date_list[$count_unique_holyday - 1] > $schedule->work_date) {
					$holyday_starttime = $timeRhstart;
					$holyday_endtime = $timeRhend;

				} elseif ($date_list[0] == $schedule->work_date && $date_list[$count_unique_holyday - 1] > $schedule->work_date) {
					$holyday_starttime = $holyday_as_weekend->start_time;
					$holyday_endtime = $timeRhend;
					// if ($holyday_starttime>$holyday_endtime) {
					//     $holyday_endtime=$holyday_starttime;
					//    }

				}
				return $this->CalculateActualStartTimeEndTimeForHolydays($schedule->work_date, $timeRhstart, $timeRhend, $holyday_starttime, $holyday_endtime, 00.00);
			}
		}

	}

	public function GetWeekend_day($weekend) {
		$day = ['sun', 'mon', 'tue', 'wed', 'thi', 'fri', 'sat'];
		$start_day = array_search($weekend->start_day, $day);
		$end_day = array_search($weekend->end_day, $day);
		$new_array = [];
		if ($start_day > $end_day) {
			$length = count($day);
			for ($i = $start_day; $i < $length; $i++) {
				array_push($new_array, $day[$i]);
				if ($i == count($day) - 1) {
					echo $week_end_day;
					for ($j = 0; $j <= $end_day; $j++) {
						array_push($new_array, $day[$j]);

					}

				}

			}
			$weekend_day_rang = $new_array;
		} else {
			$new_array = [];

			$length = count($day);
			for ($i = $start_day; $i <= $end_day; $i++) {
				array_push($new_array, $day[$i]);

			}
			$weekend_day_rang = $new_array;
		}
		return $new_array;
	}

	public function GetWeekendHour($curdate, $start_time, $end_time, $weekend, $schedule, $rest_time = 0.00) {
		// return $weekend->end_time;
		return $this->GetHourInrange($curdate, $start_time, $end_time, $weekend->start_time, $weekend->end_time, $rest_time);
	}

	public function CalculateTotalHourworked($start_time, $end_time, $rest_time = 0.00) {

		$rest_time = str_replace(":", '.', $rest_time);
		$rest_time = is_numeric($rest_time) ? $rest_time : 0;
		$start_time_to_decimel = $this->ConvertTimeTodecimalTime($start_time);
		$end_time_to_decimel = $this->ConvertTimeTodecimalTime($end_time);
		if ($start_time_to_decimel > $end_time_to_decimel) {
			$total_work_time = (float) (($end_time_to_decimel + 24) - $start_time_to_decimel);
		} else {
			$total_work_time = (float) ($end_time_to_decimel - $start_time_to_decimel);
		}
		$net_working_time = (float) ($total_work_time - $rest_time);
		if ($net_working_time > 0) {
			return $net_working_time;
		} else {
			return $net_working_time = 0;
		}
	}

	public function CalculateTimeDifference($manualtime, $stamplingtime) {
		$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
		if ($stamplingtime == "00:00") {
			$stamplingtime_strto = strtotime("$dafaultdate 23:59") + 60;
		} else {
			$stamplingtime_strto = strtotime("$dafaultdate $stamplingtime");
		}
		if ($manualtime == "00:00") {
			$manualtime_tostrto = strtotime("$dafaultdate 23:59") + 60;
		} else {
			$manualtime_tostrto = strtotime("$dafaultdate $manualtime");
		}

		return ((float) ($stamplingtime_strto - $manualtime_tostrto) / 3600);

	}

	public function CalculationLeaveHour($start_time, $end_time, $start_normal_time, $end_normal_time) {
		$total_work = $this->CalculationWorktime($start_time, $end_time);
		$total_work_in_normal_time = $this->CalculationWorktime($start_normal_time, $end_normal_time);
		if ($total_work < $total_work_in_normal_time) {

			return $leave_hour = (float) ($total_work_in_normal_time - $total_work);
		} else {
			return $leave_hour = 0;
		}
	}

	public function CalculationWorktime($start_time, $end_time) {
		$start_time_to_decimel = $this->ConvertTimeTodecimalTime($start_time);
		$end_time_to_decimel = $this->ConvertTimeTodecimalTime($end_time);
		if ($start_time_to_decimel > $end_time_to_decimel) {
			return $total_work = (float) ((float) ($end_time_to_decimel + 24) - $start_time_to_decimel);
		} else {
			return $total_work = (float) ($end_time_to_decimel - $start_time_to_decimel);
		}

	}

	public function CalculationOfTotalhourWorkedInDateARange($request, $employee_id, $primarey_id, $substitute_status) {
		//return $primarey_id;
		$now = Carbon::now('Europe/Bratislava');
		$current_year = $now->year;
		$current_month = $now->month;
		$start_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-01';
		$enddate_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-31';

		$total_worked = 0;
		$shedulepass = shedulepass::where('employee_id', $employee_id)
			->where('work_date', '<', Carbon::today('Europe/Bratislava')->toDateString())
			->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date, $enddate_date])->with('arb_pass')->orderBy('work_date', 'ASC')->get();

		if (!empty($shedulepass)) {
			foreach ($shedulepass as $schedule) {

				$start_time = $schedule->change_start_time ?? $schedule->substitute_start_time ?? $schedule->arb_pass->start_time;
				if ($schedule->extra == 1 || $schedule->is_substitute == 1) {
					$start_time = $schedule->extra_time_start ?? $schedule->substitute_start_time ?? $schedule->arb_pass->start_time;
				}
				$end_time = $schedule->change_end_time ?? $schedule->substitute_end_time ?? $schedule->arb_pass->end_time;

				if ($schedule->extra == 1 || $schedule->is_substitute == 1) {$end_time = $schedule->extra_time_end ?? $schedule->substitute_end_time ?? $schedule->arb_pass->end_time;}

				$rest_start_time = $schedule->extra_rest_start_time ?? $schedule->substitute_rest_start_time ?? $schedule->arb_pass->rest_start_time;
				$rest_end_time = $schedule->extra_rest_end_time ?? $schedule->substitute_rest_end_time ?? $schedule->arb_pass->rest_end_time;

				if ($rest_start_time != $rest_end_time) {
					$rest_time_cal = $this->GetHourInrange($schedule->work_date, $start_time, $end_time, $rest_start_time, $rest_end_time);
					$rest_time = (float) ($rest_time_cal ?? 0);
				} else {
					$rest_time = 0;
				}

				$working_hour_total = (float) ($this->CalculateTotalHourworked($start_time, $end_time, $rest_time));
				$total_worked = (float) ($total_worked + $working_hour_total);

			}
			return $total_worked;

		}

	}

	public function CalculationPreplanedActualHour($request, $employee_id, $primarey_id, $substitute_status) {
		$now = Carbon::now('Europe/Bratislava');
		$current_year = $now->year;
		$current_month = $now->month;
		$start_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-01';
		$enddate_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-31';
		if ($substitute_status == 0) {
			$shedulepass = shedulepass::where('employee_id', $employee_id)->where('is_substitute', '!=', 1)->where('extra', '!=', 1)
				->where('work_date', '<', Carbon::today('Europe/Bratislava')->toDateString())
				->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date, $enddate_date])->with('arb_pass')->orderBy('work_date', 'ASC')->get();
			$total_worked = 0;
			if (!empty($shedulepass)) {
				foreach ($shedulepass as $schedule) {
					$start_time = $schedule->arb_pass->start_time;
					$end_time = $schedule->arb_pass->end_time;
					$rest_time = $this->GetHourInrange($curdate, $start_time, $end_time, $schedule->arb_pass->rest_start_time, $schedule->arb_pass->rest_end_time, 00.00) ?? 0;
					$working_hour_total = $this->CalculateTotalHourworked($start_time, $end_time, $rest_time) ?? 0;
					$total_worked = (float) ($total_worked + $working_hour_total);

				}
				return $total_worked;

			}
		}

	}
	// view extra time in select box
	public function CalculationActualHourForextra($date, $employee_id, $primarey_id, $substitute_status) {
		$now = new Carbon($date);
		$current_year = $now->year;
		$current_month = $now->month;
		$start_date = $current_year . '-' . $current_month . '-01';
		$enddate_date = $current_year . '-' . $current_month . '-31';
		if ($substitute_status == 0) {
			$shedulepass = shedulepass::where('employee_id', $employee_id)->where('is_substitute', '!=', 1)->where('extra', '!=', 1)
				->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date, $enddate_date])->with('arb_pass')->orderBy('work_date', 'ASC')->get();
			$total_worked = 0;
			if (!empty($shedulepass)) {
				foreach ($shedulepass as $schedule) {
					$start_time = $schedule->arb_pass->start_time;
					$end_time = $schedule->arb_pass->end_time;
					$rest_time = $this->GetHourInrange($curdate, $start_time, $end_time, $schedule->arb_pass->rest_start_time, $schedule->arb_pass->rest_end_time, 00.00) ?? 0;
					$working_hour_total = $this->CalculateTotalHourworked($start_time, $end_time, $rest_time) ?? 0;
					$total_worked = (float) ($total_worked + $working_hour_total);

				}
				return $total_worked;

			}
		}

	}
	//
	public function CalculationOfTotalExtraInDateARange($date, $employee_id, $primarey_id, $substitute_status) {
		//return $primarey_id;
		$now = new Carbon($date);
		$current_year = $now->year;
		$current_month = $now->month;
		$start_date = $current_year . '-' . $current_month . '-01';
		$enddate_date = $current_year . '-' . $current_month . '-31';

		$total_worked = 0;
		$shedulepass = shedulepass::where('employee_id', $employee_id)
			->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date, $enddate_date])->with('arb_pass')->orderBy('work_date', 'ASC')->get();

		if (!empty($shedulepass)) {
			foreach ($shedulepass as $schedule) {

				$start_time = $schedule->change_start_time ?? $schedule->extra_time_start ?? $schedule->substitute_start_time ?? $schedule->arb_pass->start_time;

				$end_time = $schedule->change_end_time ?? $schedule->extra_time_end ?? $schedule->substitute_end_time ?? $schedule->arb_pass->end_time;

				$rest_start_time = $schedule->extra_rest_start_time ?? $schedule->substitute_rest_start_time ?? $schedule->arb_pass->rest_start_time;
				$rest_end_time = $schedule->extra_rest_end_time ?? $schedule->substitute_rest_end_time ?? $schedule->arb_pass->rest_end_time;
				if ($rest_start_time != $rest_end_time) {
					$rest_time_cal = $this->GetHourInrange($schedule->work_date, $start_time, $end_time, $rest_start_time, $rest_end_time);
					$rest_time = (float) ($rest_time_cal ?? 0);
				} else {
					$rest_time = 0;
				}

				$working_hour_total = (float) ($this->CalculateTotalHourworked($start_time, $end_time, $rest_time));
				$total_worked = (float) ($total_worked + ($working_hour_total ?? 0));

			}
			return $total_worked;

		}

	}

	public function CalculationOfTotalExtraInRangeFemployee($date, $employee_id, $primarey_id, $substitute_status) {
		//return $primarey_id;
		$now = new Carbon($date);
		$current_year = $now->year;
		$current_month = $now->month;
		$start_date = $current_year . '-' . $current_month . '-01';
		$enddate_date = $current_year . '-' . $current_month . '-31';

		$total_worked = 0;
		$shedulepass = shedulepass::where('employee_id', $employee_id)
			->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date, $enddate_date])->with('arb_pass')->orderBy('work_date', 'ASC')->get();

		if (!empty($shedulepass)) {
			foreach ($shedulepass as $schedule) {

				if ($schedule->extra == 1 || $schedule->is_substitute == 1) {
					$start_time = $schedule->change_end_time ?? $schedule->extra_time_start ?? $schedule->substitute_start_time ?? $schedule->arb_pass->start_time;
					$end_time = $schedule->change_end_time ?? $schedule->extra_time_end ?? $schedule->substitute_end_time ?? $schedule->arb_pass->end_time;
					$rest_start_time = $schedule->extra_rest_start_time ?? $schedule->substitute_rest_start_time ?? $schedule->arb_pass->rest_start_time;
					$rest_end_time = $schedule->extra_rest_end_time ?? $schedule->substitute_rest_end_time ?? $schedule->arb_pass->rest_end_time;
					if ($rest_start_time != $rest_end_time) {
						$rest_time_cal = $this->GetHourInrange($schedule->work_date, $start_time, $end_time, $rest_start_time, $rest_end_time);
						$rest_time = (float) ($rest_time_cal ?? 0);
					} else {
						$rest_time = 0;
					}

					$working_hour_total = (float) ($this->CalculateTotalHourworked($start_time, $end_time, $rest_time));
					$total_worked = (float) ($total_worked + $working_hour_total);
				}
			}
			return $total_worked;

		}

	}

	public function GetRoundTime($string) {
		$data = substr($string, strpos($string, ":") + 1);
		if ($data == '59') {
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			$adding_time = strtotime("$dafaultdate $string") + 60;
			return date("H:i", $adding_time);
		} else {
			return $string;
		}

	}
	public function GetEndingTimeInsleep($string, $sleepinghour) {
		if ($string == '00:00') {
			$string = '23:59';
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			$adding_time = strtotime("$dafaultdate $string") + 60 + ($sleepinghour * 3600);
			if ($dafaultdate < date("Y-m-d", $adding_time)) {
				return '00:00';
			} else {
				return date("H:i", $adding_time);
			}
		} else {
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			$adding_time = strtotime("$dafaultdate $string") + ($sleepinghour * 3600);
			if ($dafaultdate < date("Y-m-d", $adding_time)) {
				return '00:00';
			} else {
				return date("H:i", $adding_time);
			}
		}

	}

	public function StartEndINsleepNext($start_time, $string, $sleepinghour) {
		if ($string == '00:00') {
			$string = '23:59';
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			$adding_time = strtotime("$dafaultdate $string") + 60 + ($sleepinghour * 3600);
			if ($dafaultdate < date("Y-m-d", $adding_time)) {
				return ['00:00', date("H:i", $adding_time)];
			}
		} else {
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			$adding_time = strtotime("$dafaultdate $string") + ($sleepinghour * 3600);
			if ($dafaultdate < date("Y-m-d", $adding_time)) {
				return ['00:00', date("H:i", $adding_time)];
			}
		}

	}

	public function StartEndINsleepNextPrevmonth($start_time, $string, $sleepinghour) {
		$sleepinghour = str_replace(":", '.', $sleepinghour);
		if ($string == '00:00') {
			$string = '23:59';
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			$adding_time = strtotime("$dafaultdate $string") + 60 + ($sleepinghour * 3600);
			if ($dafaultdate < date("Y-m-d", $adding_time)) {
				return ['00:00', date("H:i", $adding_time)];
			}
		} else {
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			$adding_time = strtotime("$dafaultdate $string") + ($sleepinghour * 3600);
			if ($dafaultdate < date("Y-m-d", $adding_time)) {
				return ['00:00', date("H:i", $adding_time)];
			}
		}
	}

	public function TotalHourInSleep($start_time, $end_time) {
		$start_time = $this->ConvertTimeTodecimalTime($start_time);
		$end_time = $this->ConvertTimeTodecimalTime($end_time);
		if ($start_time > $end_time) {
			return (float) (24 - $start_time);
		} else {
			return (float) ($end_time - $start_time);
		}
	}

	public function GetLowerAccessRangeStarttime($string) {
		$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
		return $adding_time = strtotime("$dafaultdate $string") - 300;
		return date("Y-m-d H:i", $adding_time);
	}
	public function GetUpperAccessRangestarttime($string) {
		$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
		return $adding_time = strtotime("$dafaultdate $string") + 300;
		return date("Y-m-d H:i", $adding_time);
	}
	public function GetLowerAccessRangeEndtime($string) {
		if ($string == '00:00') {
			$string = '23:59';
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			return $adding_time = strtotime("$dafaultdate $string") - 254;
			return date("Y-m-d H:i", $adding_time);
		} else {
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			return $adding_time = strtotime("$dafaultdate $string") - 300;
			return date("Y-m-d H:i", $adding_time);

		}

	}
	public function GetUpperAccessRangeEndtime($string) {
		if ($string == '00:00') {
			$string = '23:59';
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			return $adding_time = strtotime("$dafaultdate $string") + 360;
			return date("Y-m-d H:i", $adding_time);
		} else {
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			return $adding_time = strtotime("$dafaultdate $string") + 300;
			return date("Y-m-d H:i", $adding_time);

		}
	}

	public function UnixtimestampssStarttime($string) {
		$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
		return $adding_time = strtotime("$dafaultdate $string");

	}
	public function UnixtimestampssEndtime($string) {
		if ($string == '00:00') {
			$string = '23:59';
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			return $adding_time = strtotime("$dafaultdate $string") + 60;
			return date("Y-m-d H:i", $adding_time);
		} else {
			$dafaultdate = Carbon::today('Europe/Bratislava')->toDateString();
			return $adding_time = strtotime("$dafaultdate $string");
			return date("Y-m-d H:i", $adding_time);

		}
	}

}