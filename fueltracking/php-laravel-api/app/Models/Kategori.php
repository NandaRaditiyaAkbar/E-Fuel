<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Kategori extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'kategori';
	

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
	protected $fillable = ["kategori","jenis_kendaraan","jenis_bbm","no_polisi"];
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				kategori LIKE ?  OR 
				jenis_kendaraan LIKE ?  OR 
				jenis_bbm LIKE ?  OR 
				no_polisi LIKE ? 
		)';
		$search_params = [
			"%$text%","%$text%","%$text%","%$text%"
		];
		//setting search conditions
		$query->whereRaw($search_condition, $search_params);
	}
	

	/**
     * return list page fields of the model.
     * 
     * @return array
     */
	public static function listFields(){
		return [ 
			"id", 
			"kategori", 
			"jenis_kendaraan", 
			"jenis_bbm", 
			"no_polisi" 
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
			"kategori", 
			"jenis_kendaraan", 
			"jenis_bbm", 
			"no_polisi" 
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
			"kategori", 
			"jenis_kendaraan", 
			"jenis_bbm", 
			"no_polisi" 
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
			"kategori", 
			"jenis_kendaraan", 
			"jenis_bbm", 
			"no_polisi" 
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
			"kategori", 
			"jenis_kendaraan", 
			"jenis_bbm", 
			"no_polisi" 
		];
	}
	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
}
