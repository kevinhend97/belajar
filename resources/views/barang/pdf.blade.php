<!DOCTYPE html>
<html>
<head>
    <title>Daftar Supplier</title>
    <style type="text/css">
        body{
            font-family: sans-serif;
            font-size: 11pt;
        }
        table, th, td
        {
            border: 1px solid black;
            border-collapse: collapse;
            opacity: 0.95;
        }
        table{
            width: 90%;
        }
        th
        {
            padding: 10px;
            text-align: center;
        }
        th
        {
            background-color: #a70000;
            color: white;
        }
        tr:nth-child(even)
        {
            background-color: #e8e8e8;
        }
        tr:nth-child(odd)
        {
            background-color: white;
        }
        #header
        {
            background-color: #005cb7;
            color: white;
        }
        td
        {
            text-align: left;
            padding: 10px;
        }
        .kop
        {
            width: 80%;
            border: none;
        }
        h1
        {
            font-size: 50px;
        }
    </style>
</head>
<body>
    <div class="content">
        <table width="80%" class="kop">
            <td style="border: none;"><img src="{{ asset('uploads/avatar/logo.jpg') }}" width="150"></td>
            <td style="border: none;" colspan="4"><center><h2>Daftar Barang TB Wuni Periode {{ $tanggalKertas }}</h2>
                <b>Jalan Wuni No.17 RT.02/RW.10, Tegalreja, Cilacap, Jawa Tengah</b></center></td>
        </table>
        <br>
        <table align="center">
            <tr>
                <th width="30">No.</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
            </tr>
            @foreach($barang as $data)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $data->kode_barang }}</td>
                <td>{{ $data->nama_barang }}</td>
                <td>{{ $data->qty }}</td>
                <td>{{ $data->nama_satuan }}</td>
                <td> Rp.{{ format_uang($data->harga_beli) }} </td>
                <td> RP.{{ format_uang($data->harga_jual) }} </td>
            </tr>
            @endforeach
            
        </table>
    </div>
</body>
</html>