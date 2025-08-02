<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Barang</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Laporan Stok Barang</h2>
    <p>Tanggal: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Stock fisik</th>
                <th>Status</th>
                <th>Dibuat oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                <td>{{ $row->product->kode_product ?? '-' }}</td>
                <td>{{ $row->product->name ?? '-' }}</td>
                <td>{{ $row->product->category->name ?? '-' }}</td>
                <td>{{ $row->type }}</td>
                <td>{{ $row->quantity }}</td>
                <td>{{ $row->latestOpname->real_quantity ?? '-' }}</td>
                <td>{{ $row->status }}</td>
                <td>{{ $row->user->name ?? '-' }} ({{ $row->user->role ?? '-' }})</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
