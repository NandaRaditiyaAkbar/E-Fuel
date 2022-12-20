<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherAddRequest;
use App\Http\Requests\VoucherEditRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;
use \PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VoucherListExport;
use App\Exports\VoucherViewExport;
use Exception;
class VoucherController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$query = Voucher::query();
		if($request->search){
			$search = trim($request->search);
			Voucher::search($query, $search);
		}
		$orderby = $request->orderby ?? "voucher.id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a single field name
		}
		// if request format is for export example:- product/index?export=pdf
		if($this->getExportFormat()){
			return $this->ExportList($query); // export current query
		}
		$records = $this->paginate($query, Voucher::listFields());
		return $this->respond($records);
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Voucher::query();
		// if request format is for export example:- product/view/344?export=pdf
		if($this->getExportFormat()){
			return $this->ExportView($query, $rec_id);
		}
		$record = $query->findOrFail($rec_id, Voucher::viewFields());
		return $this->respond($record);
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function add(VoucherAddRequest $request){
		$modeldata = $request->validated();
		
		if( array_key_exists("foto_dashboard", $modeldata) ){
			//move uploaded file from temp directory to destination directory
			$fileInfo = $this->moveUploadedFiles($modeldata['foto_dashboard'], "foto_dashboard");
			$modeldata['foto_dashboard'] = $fileInfo['filepath'];
		}
		
		if( array_key_exists("foto_struk", $modeldata) ){
			//move uploaded file from temp directory to destination directory
			$fileInfo = $this->moveUploadedFiles($modeldata['foto_struk'], "foto_struk");
			$modeldata['foto_struk'] = $fileInfo['filepath'];
		}
		
		if( array_key_exists("bukti_pengajuan", $modeldata) ){
			//move uploaded file from temp directory to destination directory
			$fileInfo = $this->moveUploadedFiles($modeldata['bukti_pengajuan'], "bukti_pengajuan");
			$modeldata['bukti_pengajuan'] = $fileInfo['filepath'];
		}
		
		//save Voucher record
		$record = Voucher::create($modeldata);
		$rec_id = $record->id;
		return $this->respond($record);
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(VoucherEditRequest $request, $rec_id = null){
		$query = Voucher::query();
		$record = $query->findOrFail($rec_id, Voucher::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $request->validated();
		
		if( array_key_exists("foto_dashboard", $modeldata) ){
			//move uploaded file from temp directory to destination directory
			$fileInfo = $this->moveUploadedFiles($modeldata['foto_dashboard'], "foto_dashboard");
			$modeldata['foto_dashboard'] = $fileInfo['filepath'];
		}
		
		if( array_key_exists("foto_struk", $modeldata) ){
			//move uploaded file from temp directory to destination directory
			$fileInfo = $this->moveUploadedFiles($modeldata['foto_struk'], "foto_struk");
			$modeldata['foto_struk'] = $fileInfo['filepath'];
		}
		
		if( array_key_exists("bukti_pengajuan", $modeldata) ){
			//move uploaded file from temp directory to destination directory
			$fileInfo = $this->moveUploadedFiles($modeldata['bukti_pengajuan'], "bukti_pengajuan");
			$modeldata['bukti_pengajuan'] = $fileInfo['filepath'];
		}
			$record->update($modeldata);
		}
		return $this->respond($record);
	}
	

	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
	 * @param  \Illuminate\Http\Request
	 * @param string $rec_id //can be separated by comma 
     * @return \Illuminate\Http\Response
     */
	function delete(Request $request, $rec_id = null){
		$arr_id = explode(",", $rec_id);
		$query = Voucher::query();
		$query->whereIn("id", $arr_id);
		$records = $query->get(['foto_dashboard']); //get records files to be deleted before delete
		$query->delete();
		foreach($records as $record){
			$this->deleteRecordFiles($record['foto_dashboard'], "foto_dashboard"); //delete file after record delete
		}
		return $this->respond($arr_id);
	}
	

	/**
     * Export table records to different format
	 * supported format:- PDF, CSV, EXCEL, HTML
	 * @param \Illuminate\Database\Eloquent\Model $query
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
	private function ExportList($query){
		ob_end_clean(); // clean any output to allow file download
		$filename = "ListVoucherReport-" . date_now();
		$format = $this->getExportFormat();
		if($format == "print"){
			$records = $query->get(Voucher::exportListFields());
			return view("reports.voucher-list", ["records" => $records]);
		}
		elseif($format == "pdf"){
			$records = $query->get(Voucher::exportListFields());
			$pdf = PDF::loadView("reports.voucher-list", ["records" => $records]);
			return $pdf->download("$filename.pdf");
		}
		elseif($format == "csv"){
			return Excel::download(new VoucherListExport($query), "$filename.csv", \Maatwebsite\Excel\Excel::CSV);
		}
		elseif($format == "excel"){
			return Excel::download(new VoucherListExport($query), "$filename.xlsx", \Maatwebsite\Excel\Excel::XLSX);
		}
	}
	

	/**
     * Export single record to different format
	 * supported format:- PDF, CSV, EXCEL, HTML
	 * @param \Illuminate\Database\Eloquent\Model $record
	 * @param string $rec_id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
	private function ExportView($query, $rec_id){
		ob_end_clean();// clean any output to allow file download
		$filename ="ViewVoucherReport-" . date_now();
		$format = $this->getExportFormat();
		if($format == "print"){
			$record = $query->findOrFail($rec_id, Voucher::exportViewFields());
			return view("reports.voucher-view", ["record" => $record]);
		}
		elseif($format == "pdf"){
			$record = $query->findOrFail($rec_id, Voucher::exportViewFields());
			$pdf = PDF::loadView("reports.voucher-view", ["record" => $record]);
			return $pdf->download("$filename.pdf");
		}
		elseif($format == "csv"){
			return Excel::download(new VoucherViewExport($query, $rec_id), "$filename.csv", \Maatwebsite\Excel\Excel::CSV);
		}
		elseif($format == "excel"){
			return Excel::download(new VoucherViewExport($query, $rec_id), "$filename.xlsx", \Maatwebsite\Excel\Excel::XLSX);
		}
	}
}
