<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { padding: 8px; border: 1px solid #000; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Transaksi Stok</h2>
    <table>
        <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Nama Produk</th>
            <td>{{ $row->product->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $row->product->category->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Jenis Transaksi</th>
            <td>{{ ucfirst($row->type) }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $row->quantity }}</td>
        </tr>
        <tr>
            <th>Harga beli</th>
            <td>Rp {{ number_format($row->product->purchase_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Harga jual</th>
            <td>Rp {{ number_format($row->product->selling_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($row->status ?? '-') }}</td>
        </tr>
        <tr>
            <th>Dibuat Oleh</th>
            <td>{{ $row->user->name ?? 'N/A' }} ({{ $row->user->role ?? '-' }})</td>
        </tr>
    </table>
</body>
</html>
