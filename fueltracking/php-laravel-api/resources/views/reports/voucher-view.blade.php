
@extends('layouts.report')
@section('content')
<div id="report-title"><h1></h1></div>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>Tanggal</th>
            <td>{{ $record->tanggal }}</td>
        </tr>
        <tr>
            <th>Nama Peminta</th>
            <td>{{ $record->nama_peminta }}</td>
        </tr>
        <tr>
            <th>Jenis Kendaraan</th>
            <td>{{ $record->jenis_kendaraan }}</td>
        </tr>
        <tr>
            <th>Jenis Bbm</th>
            <td>{{ $record->jenis_bbm }}</td>
        </tr>
        <tr>
            <th>Jumlah Liter</th>
            <td>{{ $record->jumlah_liter }}</td>
        </tr>
        <tr>
            <th>Jumlah Harga</th>
            <td>{{ $record->jumlah_harga }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <td>{{ $record->total }}</td>
        </tr>
        <tr>
            <th>Km Dashboard</th>
            <td>{{ $record->km_dashboard }}</td>
        </tr>
        <tr>
            <th>Foto Dashboard</th>
            <td>{{ $record->foto_dashboard }}</td>
        </tr>
        <tr>
            <th>Foto Struk</th>
            <td>{{ $record->foto_struk }}</td>
        </tr>
        <tr>
            <th>Bukti Pengajuan</th>
            <td>{{ $record->bukti_pengajuan }}</td>
        </tr>
    </tbody>
</table>
@endsection
