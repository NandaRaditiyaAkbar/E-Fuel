<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class VoucherEditRequest extends FormRequest
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
            
				"tanggal" => "filled|date",
				"nama_peminta" => "filled|string",
				"jenis_kendaraan" => "filled",
				"km_dashboard" => "filled|string",
				"jenis_bbm" => "filled|string",
				"jumlah_liter" => "filled|string",
				"jumlah_harga" => "filled|string",
				"total" => "filled|numeric",
				"foto_dashboard" => "filled",
				"foto_struk" => "filled",
				"bukti_pengajuan" => "filled",
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
