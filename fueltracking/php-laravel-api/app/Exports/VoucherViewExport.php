<?php 

namespace App\Exports;
use App\Models\Voucher;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class VoucherViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Voucher::exportViewFields());
        $this->rec_id = $rec_id;
    }


    public function query()
    {
        return $this->query->where("id", $this->rec_id);
    }


	public function headings(): array
    {
        return [
			'Tanggal',
			'Nama Peminta',
			'Jenis Kendaraan',
			'Jenis Bbm',
			'Jumlah Liter',
			'Jumlah Harga',
			'Total',
			'Km Dashboard',
			'Foto Dashboard',
			'Foto Struk',
			'Bukti Pengajuan'
        ];
    }


    public function map($record): array
    {
        return [
			$record->tanggal,
			$record->nama_peminta,
			$record->jenis_kendaraan,
			$record->jenis_bbm,
			$record->jumlah_liter,
			$record->jumlah_harga,
			$record->total,
			$record->km_dashboard,
			$record->foto_dashboard,
			$record->foto_struk,
			$record->bukti_pengajuan
        ];
    }
}
