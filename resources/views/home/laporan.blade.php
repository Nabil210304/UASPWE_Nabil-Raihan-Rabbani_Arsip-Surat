<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Arsip</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Laporan Arsip per Kategori</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Total Arsip</th>
            </tr>
        </thead>
        <tbody>
            @foreach($arsipPerKategori as $index => $arsip)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $arsip->nama ?? 'Tanpa Kategori' }}</td>
                <td>{{ $arsip->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
