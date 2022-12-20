<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class Users extends Authenticatable 
{
	use Notifiable, HasApiTokens;
	use HasRoles;
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'users';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'id';
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["name","email","password","telephone"];
	/**
     * Table fields which are not included in select statement
     *
     * @var array
     */
	protected $hidden = ['password', 'token'];
	

	/**
     * return list page fields of the model.
     * 
     * @return array
     */
	public static function listFields(){
		return [ 
			"id", 
			"name", 
			"email", 
			"telephone" 
		];
	}
	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"id", 
			"name", 
			"email", 
			"telephone" 
		];
	}
	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"id", 
			"name", 
			"email", 
			"telephone" 
		];
	}
	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"id", 
			"name", 
			"email", 
			"telephone" 
		];
	}
	

	/**
     * return accountedit page fields of the model.
     * 
     * @return array
     */
	public static function accounteditFields(){
		return [ 
			"id", 
			"name", 
			"telephone" 
		];
	}
	

	/**
     * return accountview page fields of the model.
     * 
     * @return array
     */
	public static function accountviewFields(){
		return [ 
			"id", 
			"name", 
			"email", 
			"telephone" 
		];
	}
	

	/**
     * return exportAccountview page fields of the model.
     * 
     * @return array
     */
	public static function exportAccountviewFields(){
		return [ 
			"id", 
			"name", 
			"email", 
			"telephone" 
		];
	}
	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"id", 
			"name", 
			"telephone" 
		];
	}
	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
	

	/**
     * Get current user name
     * @return string
     */
	public function UserName(){
		return $this->name;
	}
	

	/**
     * Get current user id
     * @return string
     */
	public function UserId(){
		return $this->id;
	}
	public function UserEmail(){
		return $this->email;
	}
	public function UserRole(){
		return $this->user_role_id;
	}
	

	/**
     * Send Password reset link to user email 
	 * @param string $token
     * @return string
     */
	public function sendPasswordResetNotification($token)
	{
		// Your your own implementation.
		$this->notify(new \App\Notifications\ResetPassword($token));
	}
}
