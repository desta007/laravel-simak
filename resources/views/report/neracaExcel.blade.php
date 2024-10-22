<table>
    <thead>
        <tr>
            <th>Laporan Neraca {{ date('F', mktime(0, 0, 0, $bulan, 1)) }} {{ $tahun }}</th>
        </tr>
        <tr>
            <th>Cabang</th>
            <th>{{ $namaCabang }}</th>
        </tr>
        <tr>
            <th>Proyek</th>
            <th>{{ $namaProyek }}</th>
        </tr>
    </thead>

</table>
