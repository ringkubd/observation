<?php
namespace App\helper;
use App\Role;
use App\User;
use Auth;
use Illuminate\Http\Request;

class helper {

	public function transfer_day_name($day_name) {
		$day_name_upper = strtoupper($day_name);
		switch ($day_name_upper) {
		case 'MONDAY':
			return 'Måndag';
			break;
		case 'TUESDAY':
			return 'Tisdag';
			break;
		case 'WEDNESDAY':
			return 'Onsdag';
			break;
		case 'THURSDAY':
			return 'Torsdag';
			break;
		case 'FRIDAY':
			return 'Fredag';
		case 'SATURDAY':
			return 'Lördag';
		case 'SUNDAY':
			return 'Söndag';
			break;

		default:
			# code...
			break;
		}
	}
	public function is_company() {
		if (Auth::check()) {
			return false;

		} else {
			return true;
		}
	}

	public function userRoleUpdate(Request $request) {
		$userid = $request->userid;
		$user = User::findOrFail($userid);
		$this->validate($request, [
			'full_name' => 'required|max:120',
			'email' => 'required|email|unique:users,email,' . $userid,
		]);

		//$user->password   = bcrypt($request->password);

		$user->full_name = $request->full_name;
		$user->email = $request->email;

		// $input = $request->except('roles');->fill($input)

		if ($request->assign_role != '') {
			$user->roles()->sync($request->assign_role);
		} else {
			$user->roles()->detach();
		}
		return redirect()->route('users.index')->with('success',
			'User successfully updated.');
	}
	public function userInfoEditData(Request $request) {

		if ($request->ajax()) {
			if (Auth::check()) {
				$roles = Role::whereNotIn('name', ['Admin', 'Owner'])->get()->toArray();
			} elseif (Auth::guard('owner')->check() || Auth::user()->hasRole('Owner')) {
				$roles = Role::all()->toArray();
			}

			$userinf[] = User::whereId($request->userid)->get()->toArray();

			array_push($userinf, $roles);

			return response($userinf);
		} else {
			return back()->with('msg', 'You dont have access on this page..');
		}

	}
	private function userdataprivate() {
		if (Auth::check()) {
			return Auth::user();

		} elseif (Auth::guard('owner')->check()) {
			return Auth::guard('owner')->user();
		}
	}

	// retrun user name user id ,user mail , user contact number , user adress

	public function user_data($user_data = array()) {
		$userifo = $this->userdataprivate();

		if (!is_array($user_data)) {

			switch ($user_data) {
			case 'full_name':
				if (Auth::check()) {
					return $userifo->full_name;

				} else {
					return $userifo->company_name;
				}
				break;
			case 'user_image':
				if (Auth::check()) {
					return $userifo->employee_image;

				} else {
					return $userifo->company_name;
				}
				break;
			case 'id':
				if (Auth::check()) {
					return $userifo->id;

				} else {
					return $userifo->company_id;
				}

				break;
			case 'email':
				return $userifo->email;
				break;
			case 'mobile':
				return $userifo->mobile;
				break;

			case 'personal_number':
				return $userifo->personal_number;
				break;

			default:
				// code...
				break;
			}

		} else {
			$arryuserinfo = [];

			foreach ($user_data as $value) {
				array_push($arryuserinfo, $userifo->$value);

			}
			return $arryuserinfo;
		}
	}

	public function ConvertTimeTodecimalTime($string): float{
		$replace_colon = explode(':', $string);
		$fractionTime = (float) ($replace_colon[1] / 60);
		return $floatTime = $replace_colon[0] + $fractionTime;
	}
	//this function is not needed
	public function ConvertTimeDecimalToNormalTime($string) {
		$replace_colon = explode('.', $string);
		$fraction_field = (float) ('0.' . $replace_colon[1]);
		$fractionTime = (float) ($fraction_field * 60);
		return $NormalTime = $replace_colon[0] . ':' . $fractionTime;

	}

	public function getIndex($name, $array) {
		$i = 1;
		foreach ($array as $a) {
			if (in_array($name, $a)) {
				return $i;
			}
			$i++;

		}
		return null;

	}

	static function numberFormat($amount = null) {
		$amount = (float) $amount;
		return number_format($amount, '2', '.', ',');
	}

}
