<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Role_Has_Permissions extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'role_has_permissions';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'role_id';
	public $incrementing = false;
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["permission_id","role_id"];
	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
		];
	}
	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
		];
	}
	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
}
