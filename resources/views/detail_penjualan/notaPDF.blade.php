<!DOCTYPE html>
<html>
<head>
   <title>Nota PDF</title>
   <style type="text/css">
      table td{font: arial 12px;}
      table.data td,
      table.data th{
         border: 1px solid #ccc;
         padding: 5px;
      }
      table.data th{
         text-align: center;
      }
      table.data{ border-collapse: collapse }
      table.head1 td{
        font-family: sans-serif;
        /*color: #232323;
        border-collapse: collapse;*/
      }
   </style>
</head>
<body>

<table class="head1" width="100%">
  <tr>
     <td rowspan="2" width="60%"><img src="{{ asset('uploads/avatar/logowuni.jpg') }}" width="150"><br><br>
     <font face="sans-serif">Jalan Wuni No.17, Tegalreja, Cilacap Selatan</font><br><br>
     </td>
     <td>Tanggal</td>
     <td>: {{ tanggal_indonesia(date('Y-m-d')) }}</td>
  </tr>     
  <tr>
     <td>Kode Member</td>
     <td>: {{ $penjualan->kode_pelanggan }}</td>
  </tr>
</table>
         
<table width="100%" class="data">
<thead>
   <tr>
    <th>No</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Harga Satuan</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
   </tr>
</thead>

   <tbody>
    @foreach($detail as $data)
      
    <tr>
       <td>{{ ++$no }}</td>
       <td>{{ $data->kode_barang }}</td>
       <td>{{ $data->nama_barang }}</td>
       <td align="right">{{ format_uang($data->harga_jual) }}</td>
       <td>{{ $data->jumlah }}</td>
       <td align="right">{{ format_uang($data->sub_total) }}</td>
    </tr>
    @endforeach
   
   </tbody>
   <tfoot>
    <tr><td colspan="5" align="right"><b>Total Harga</b></td><td align="right"><b>{{ format_uang($penjualan->total_harga) }}</b></td></tr>
    <tr><td colspan="5" align="right"><b>Diskon</b></td><td align="right"><b>{{ format_uang($penjualan->diskon) }}%</b></td></tr>
    <tr><td colspan="5" align="right"><b>Total Bayar</b></td><td align="right"><b>{{ format_uang($penjualan->bayar) }}</b></td></tr>
    <tr><td colspan="5" align="right"><b>Diterima</b></td><td align="right"><b>{{ format_uang($penjualan->diterima) }}</b></td></tr>
    <tr><td colspan="5" align="right"><b>Kembali</b></td><td align="right"><b>{{ format_uang($penjualan->diterima - $penjualan->bayar) }}</b></td></tr>
   </tfoot>
</table>

<table width="100%">
  <tr>
    <td>
      <b>Terimakasih telah berbelanja dan sampai jumpa</b>
    </td>
    <td align="center">
      Kasir<br><br><br> {{Auth::user()->name}}
    </td>
  </tr>
</table>
</body>
</html>