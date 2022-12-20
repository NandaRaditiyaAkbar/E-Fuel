<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tb_BahanbakarAddRequest;
use App\Http\Requests\Tb_BahanbakarEditRequest;
use App\Models\Tb_Bahanbakar;
use Illuminate\Http\Request;
use Exception;
class Tb_BahanbakarController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$query = Tb_Bahanbakar::query();
		if($request->search){
			$search = trim($request->search);
			Tb_Bahanbakar::search($query, $search);
		}
		$orderby = $request->orderby ?? "tb_bahanbakar.id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$records = $this->paginate($query, Tb_Bahanbakar::listFields());
		return $this->respond($records);
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Tb_Bahanbakar::query();
		$record = $query->findOrFail($rec_id, Tb_Bahanbakar::viewFields());
		return $this->respond($record);
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function add(Tb_BahanbakarAddRequest $request){
		$modeldata = $request->validated();
		
		//save Tb_Bahanbakar record
		$record = Tb_Bahanbakar::create($modeldata);
		$rec_id = $record->id;
		return $this->respond($record);
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(Tb_BahanbakarEditRequest $request, $rec_id = null){
		$query = Tb_Bahanbakar::query();
		$record = $query->findOrFail($rec_id, Tb_Bahanbakar::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $request->validated();
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
		$query = Tb_Bahanbakar::query();
		$query->whereIn("id", $arr_id);
		$query->delete();
		return $this->respond($arr_id);
	}
}
