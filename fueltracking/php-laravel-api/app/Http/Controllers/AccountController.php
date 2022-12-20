<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Http\Requests\UsersAccountEditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\permissions;
use Exception;
/**
 * Account Page Controller
 * @category  Controller
 */
class AccountController extends Controller{
	

	/**
     * Select user account data
     * @return \Illuminate\View\View
     */
	function index(){
		$rec_id = Auth::id();
		$query = Users::query();
		$record = $query->findOrFail($rec_id,  Users::accountviewFields());
		return $this->respond($record);
	}
	

	/**
     * Update user account data
     * @return \Illuminate\View\View;
     */
	function edit(UsersAccountEditRequest $request){
		$rec_id = Auth::id();
		$query = Users::query();
		$record = $query->findOrFail($rec_id, Users::accounteditFields());
		if ($request->isMethod('post')) {
			$modeldata = $request->validated();
			$record->update($modeldata);
		}
		return $this->respond($record);
	}
	function currentuserdata(){
		$user = auth()->user();
		// get list of pages which user has access
		$userPages = $user->getAllPermissions()->pluck('name'); 
		$userRoleName = $user->getRoleNames();
		$data = [
			"user" => $user,
			"pages" => $userPages,
			"roles" => $userRoleName,
		];
		return $this->respond($data);
	}
	

	/**
     * Change user account password
     * @return \Illuminate\Http\Response
     */
	public function changepassword(Request $request)
	{
		$request->validate([
			'oldpassword' => ['required'],
			'newpassword' => ['required'],
			'confirmpassword' => ['same:newpassword'],
		]);
		$userid = auth()->id();
		$user = Users::find($userid);
		$oldPasswordText = $request->oldpassword;
		$oldPasswordHash = $user->password;
		if(!Hash::check($oldPasswordText, $oldPasswordHash)){
			return $this->reject("Current password is incorrect");
		}
		$modeldata = ['password' => Hash::make($request->newpassword)];
		$user->update($modeldata);
		return $this->respond("Password changed");
	}
}
