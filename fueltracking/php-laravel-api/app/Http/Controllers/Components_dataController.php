<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
 * Components Data Contoller
 * Use for getting values from the database for page components
 * Support raw query builder
 * @category Controller
 */
class Components_dataController extends Controller{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
	/**
     * jenis_kendaraan_option_list Model Action
     * @return array
     */
	function jenis_kendaraan_option_list(Request $request){
		$sqltext = "SELECT  DISTINCT jenis_kendaraan AS value,jenis_kendaraan AS label FROM kategori";
		$query_params = [];
		$arr = DB::select(DB::raw($sqltext), $query_params);
		return $arr;
	}
	/**
     * check if name value already exist in Users
	 * @param string $value
     * @return bool
     */
	function users_name_exist(Request $request, $value){
		$exist = DB::table('users')->where('name', $value)->value('name');   
		if($exist){
			return "true";
		}
		return "false";
	}
	/**
     * check if email value already exist in Users
	 * @param string $value
     * @return bool
     */
	function users_email_exist(Request $request, $value){
		$exist = DB::table('users')->where('email', $value)->value('email');   
		if($exist){
			return "true";
		}
		return "false";
	}
	/**
     * jenis_bbm_option_list Model Action
     * @return array
     */
	function jenis_bbm_option_list(Request $request){
		$sqltext = "SELECT  DISTINCT jenis_bbm AS value,jenis_bbm AS label, harga AS price FROM tb_bahanbakar";
		$query_params = [];
		$arr = DB::select(DB::raw($sqltext), $query_params);
		return $arr;
	}
	/**
	* barchart_datapemintapengajuanvoucher Model Action
	* @return array
	*/
	function barchart_datapemintapengajuanvoucher(Request $request){
		$chart_data  = [];
		$sqltext = "SELECT  pengajuan.id, COUNT(pengajuan.nama) AS count_of_nama, pengajuan.jenis_kendaraan, pengajuan.foto_dashboard, pengajuan.status, MONTHNAME(pengajuan.tanggal) AS monthname_of_tanggal FROM pengajuan GROUP BY monthname_of_tanggal";
		$query_params = [];
		$records = DB::select(DB::raw($sqltext), $query_params);
		$chart_labels = array_column($records, 'monthname_of_tanggal');
		$datasets = [];
		$dataset1 = [
			'data' =>  array_column($records, 'count_of_nama'),
			'label' => "Jumlah Peminta",
			'backgroundColor' =>  random_color(), 
			'borderColor' =>  random_color(), 
			'borderWidth' => '',
		];
		$datasets[] = $dataset1;
		$chart_data['datasets'] = $datasets;
		$chart_data['labels'] = $chart_labels;
		return $chart_data;
	}
	/**
	* barchart_datavoucherpengisianbbm Model Action
	* @return array
	*/
	function barchart_datavoucherpengisianbbm(Request $request){
		$chart_data  = [];
		$sqltext = "SELECT  voucher.id, MONTHNAME(voucher.tanggal) AS monthname_of_tanggal, COUNT(voucher.nama_peminta) AS count_of_nama_peminta, voucher.jenis_kendaraan, voucher.km_dashboard, voucher.jenis_bbm, voucher.jumlah_liter, voucher.jumlah_harga, voucher.total, voucher.foto_dashboard, voucher.foto_struk FROM voucher GROUP BY monthname_of_tanggal";
		$query_params = [];
		$records = DB::select(DB::raw($sqltext), $query_params);
		$chart_labels = array_column($records, 'monthname_of_tanggal');
		$datasets = [];
		$dataset1 = [
			'data' =>  array_column($records, 'count_of_nama_peminta'),
			'label' => "Jumlah Voucher",
			'backgroundColor' =>  random_color(), 
			'borderColor' =>  random_color(), 
			'borderWidth' => '',
		];
		$datasets[] = $dataset1;
		$chart_data['datasets'] = $datasets;
		$chart_data['labels'] = $chart_labels;
		return $chart_data;
	}
	/**
	* barchart_datapengajuanvoucher Model Action
	* @return array
	*/
	function barchart_datapengajuanvoucher(Request $request){
		$chart_data  = [];
		$sqltext = "SELECT  pengajuan.id, COUNT(pengajuan.nama) AS count_of_nama, pengajuan.jenis_kendaraan, pengajuan.foto_dashboard, pengajuan.status, pengajuan.tanggal FROM pengajuan GROUP BY pengajuan.status";
		$query_params = [];
		$records = DB::select(DB::raw($sqltext), $query_params);
		$chart_labels = array_column($records, 'status');
		$datasets = [];
		$dataset1 = [
			'data' =>  array_column($records, 'count_of_nama'),
			'label' => "Jumlah Pengajuan",
			'backgroundColor' =>  random_color(), 
			'borderColor' =>  random_color(), 
			'borderWidth' => '',
		];
		$datasets[] = $dataset1;
		$chart_data['datasets'] = $datasets;
		$chart_data['labels'] = $chart_labels;
		return $chart_data;
	}
	/**
	* barchart_datajumlahliterperkilometer Model Action
	* @return array
	*/
	function barchart_datajumlahliterperkilometer(Request $request){
		$chart_data  = [];
		$sqltext = "SELECT  voucher.id, voucher.tanggal, voucher.nama_peminta, voucher.jenis_kendaraan, voucher.km_dashboard, voucher.jenis_bbm, SUM(voucher.jumlah_liter) AS sum_of_jumlah_liter, voucher.jumlah_harga, voucher.total, voucher.foto_dashboard, voucher.foto_struk FROM voucher GROUP BY voucher.km_dashboard";
		$query_params = [];
		$records = DB::select(DB::raw($sqltext), $query_params);
		$chart_labels = array_column($records, 'km_dashboard');
		$datasets = [];
		$dataset1 = [
			'data' =>  array_column($records, 'km_dashboard'),
			'label' => "Km Dashboard",
			'backgroundColor' =>  random_color(), 
			'borderColor' =>  random_color(), 
			'borderWidth' => '',
		];
		$datasets[] = $dataset1;
		$dataset2 = [
			'data' =>  array_column($records, 'sum_of_jumlah_liter'),
			'label' => "Jumlah Liter",
			'backgroundColor' =>  random_color(), 
			'borderColor' =>  random_color(), 
			'borderWidth' => '',
		];
		$datasets[] = $dataset2;
		$chart_data['datasets'] = $datasets;
		$chart_data['labels'] = $chart_labels;
		return $chart_data;
	}
	/**
	* barchart_datatotalpengisianbbm Model Action
	* @return array
	*/
	function barchart_datatotalpengisianbbm(Request $request){
		$chart_data  = [];
		$sqltext = "SELECT  voucher.id, MONTHNAME(voucher.tanggal) AS monthname_of_tanggal, voucher.nama_peminta, voucher.jenis_kendaraan, voucher.km_dashboard, voucher.jenis_bbm, voucher.jumlah_liter, voucher.jumlah_harga, SUM(voucher.total) AS sum_of_total, voucher.foto_dashboard, voucher.foto_struk FROM voucher GROUP BY monthname_of_tanggal";
		$query_params = [];
		$records = DB::select(DB::raw($sqltext), $query_params);
		$chart_labels = array_column($records, 'monthname_of_tanggal');
		$datasets = [];
		$dataset1 = [
			'data' =>  array_column($records, 'sum_of_total'),
			'label' => "Jumlah Total Pengisian BBM Per Bulan",
			'backgroundColor' =>  random_color(), 
			'borderColor' =>  random_color(), 
			'borderWidth' => '',
		];
		$datasets[] = $dataset1;
		$chart_data['datasets'] = $datasets;
		$chart_data['labels'] = $chart_labels;
		return $chart_data;
	}
}
