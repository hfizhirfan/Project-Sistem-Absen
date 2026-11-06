<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Lembur</title>
    <style>
        @font-face {
            font-family: 'Times New Roman';
            src: local('Times New Roman'), local('TimesNewRoman'), serif;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
        }

        .header h3 {
            font-size: 14px;
            margin: 2px 0;
        }

        .line {
            border-top: 3px solid black;
            margin: 10px 0 20px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            margin-top: 10px;
        }

        td {
            vertical-align: top;
            padding: 5px 0;
        }

        .label {
            width: 150px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1><strong>PT XYZ</strong></h1>
        <h3>Jalan jalan saja No. 20 , Surabaya, Jawa Timur</h3>
        <h3><strong>Telepon : (031) 22945612 &nbsp; | &nbsp; Email : info@ptxyz.co.id</strong></h3>
    </div>

    <div class="line"></div>

    <div class="judul">Surat Lembur</div>

    <table>
        <tr><td class="label">NIP</td><td>: {{ $lembur->nip }}</td></tr>
        <tr><td class="label">Nama</td><td>: {{ $lembur->nama }}</td></tr>
        <tr><td class="label">Jabatan</td><td>: {{ $lembur->jabatan }}</td></tr>
        <tr><td class="label">Divisi</td><td>: {{ $lembur->divisi }}</td></tr>
        <tr><td class="label">Tanggal Lembur</td><td>: {{ $lembur->tanggal_lembur }}</td></tr>
        <tr><td class="label">Jam Mulai</td><td>: {{ $lembur->jam_mulai }}</td></tr>
        <tr><td class="label">Jam Selesai</td><td>: {{ $lembur->jam_selesai }}</td></tr>
        <tr><td class="label">Keterangan</td><td>: {{ $lembur->keterangan }}</td></tr>
        <tr><td class="label">Status</td><td>: Disetujui</td></tr>

    </table>

</body>
</html>
