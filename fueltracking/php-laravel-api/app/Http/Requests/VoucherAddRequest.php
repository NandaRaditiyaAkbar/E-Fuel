<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class VoucherAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		
        return [
            
				"tanggal" => "required|date",
				"nama_peminta" => "required|string",
				"jenis_kendaraan" => "required",
				"km_dashboard" => "required|string",
				"jenis_bbm" => "required|string",
				"jumlah_liter" => "required|string",
				"jumlah_harga" => "required|string",
				"total" => "required|numeric",
				"foto_dashboard" => "required",
				"foto_struk" => "required",
				"bukti_pengajuan" => "required",
        ];
    }

	public function messages()
    {
        return [
            //using laravel default validation messages
        ];
    }

	/**
     * If validator fails return the exception in json form
     * @param Validator $validator
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
