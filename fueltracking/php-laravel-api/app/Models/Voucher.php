<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Voucher extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'voucher';
	

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
	protected $fillable = ["tanggal","nama_peminta","jenis_kendaraan","km_dashboard","jenis_bbm","jumlah_liter","jumlah_harga","total","foto_dashboard","foto_struk","bukti_pengajuan"];
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				nama_peminta LIKE ?  OR 
				jenis_kendaraan LIKE ?  OR 
				jenis_bbm LIKE ?  OR 
				jumlah_liter LIKE ?  OR 
				jumlah_harga LIKE ?  OR 
				km_dashboard LIKE ? 
		)';
		$search_params = [
			"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
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
			"tanggal", 
			"nama_peminta", 
			"jenis_kendaraan", 
			"jenis_bbm", 
			"jumlah_liter", 
			"jumlah_harga", 
			"total", 
			"km_dashboard", 
			"foto_dashboard", 
			"foto_struk", 
			"bukti_pengajuan" 
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
			"tanggal", 
			"nama_peminta", 
			"jenis_kendaraan", 
			"jenis_bbm", 
			"jumlah_liter", 
			"jumlah_harga", 
			"total", 
			"km_dashboard", 
			"foto_dashboard", 
			"foto_struk", 
			"bukti_pengajuan" 
		];
	}
	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"voucher.id AS id", 
			"voucher.tanggal AS tanggal", 
			"voucher.nama_peminta AS nama_peminta", 
			"voucher.jenis_kendaraan AS jenis_kendaraan", 
			"voucher.jenis_bbm AS jenis_bbm", 
			"voucher.jumlah_liter AS jumlah_liter", 
			"voucher.jumlah_harga AS jumlah_harga", 
			"voucher.total AS total", 
			"voucher.km_dashboard AS km_dashboard", 
			"voucher.foto_dashboard AS foto_dashboard", 
			"voucher.foto_struk AS foto_struk", 
			"voucher.bukti_pengajuan AS bukti_pengajuan" 
		];
	}
	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"voucher.id AS id", 
			"voucher.tanggal AS tanggal", 
			"voucher.nama_peminta AS nama_peminta", 
			"voucher.jenis_kendaraan AS jenis_kendaraan", 
			"voucher.jenis_bbm AS jenis_bbm", 
			"voucher.jumlah_liter AS jumlah_liter", 
			"voucher.jumlah_harga AS jumlah_harga", 
			"voucher.total AS total", 
			"voucher.km_dashboard AS km_dashboard", 
			"voucher.foto_dashboard AS foto_dashboard", 
			"voucher.foto_struk AS foto_struk", 
			"voucher.bukti_pengajuan AS bukti_pengajuan" 
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
			"tanggal", 
			"nama_peminta", 
			"jenis_kendaraan", 
			"km_dashboard", 
			"jenis_bbm", 
			"jumlah_liter", 
			"jumlah_harga", 
			"total", 
			"foto_dashboard", 
			"foto_struk", 
			"bukti_pengajuan" 
		];
	}
	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
}
