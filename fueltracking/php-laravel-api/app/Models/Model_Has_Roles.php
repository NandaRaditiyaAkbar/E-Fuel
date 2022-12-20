<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Model_Has_Roles extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'model_has_roles';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'model_id';
	public $incrementing = false;
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["role_id","model_type","model_id"];
	

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
