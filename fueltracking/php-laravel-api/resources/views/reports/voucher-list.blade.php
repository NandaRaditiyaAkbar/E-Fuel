
@extends('layouts.report')
@section('content')
<div id="report-title"><h1></h1></div>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama Peminta</th>
            <th>Jenis Kendaraan</th>
            <th>Jenis Bbm</th>
            <th>Jumlah Liter</th>
            <th>Jumlah Harga</th>
            <th>Total</th>
            <th>Km Dashboard</th>
            <th>Foto Dashboard</th>
            <th>Foto Struk</th>
            <th>Bukti Pengajuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->tanggal }}</td>
            <td>{{ $record->nama_peminta }}</td>
            <td>{{ $record->jenis_kendaraan }}</td>
            <td>{{ $record->jenis_bbm }}</td>
            <td>{{ $record->jumlah_liter }}</td>
            <td>{{ $record->jumlah_harga }}</td>
            <td>{{ $record->total }}</td>
            <td>{{ $record->km_dashboard }}</td>
            <td>{{ $record->foto_dashboard }}</td>
            <td>{{ $record->foto_struk }}</td>
            <td>{{ $record->bukti_pengajuan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
