<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Disposal Aset</title>
    <style>
        @page {
            margin: 2cm;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1e293b;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 18pt;
            color: #1e293b;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14pt;
            color: #64748b;
            font-weight: normal;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 9pt;
            color: #94a3b8;
        }

        .summary {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .summary h3 {
            margin: 0 0 10px 0;
            font-size: 12pt;
            color: #1e293b;
        }

        .summary-grid {
            display: table;
            width: 100%;
        }

        .summary-row {
            display: table-row;
        }

        .summary-label {
            display: table-cell;
            width: 40%;
            padding: 5px 10px 5px 0;
            font-weight: bold;
            color: #475569;
        }

        .summary-value {
            display: table-cell;
            padding: 5px 0;
            color: #1e293b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background: #1e293b;
            color: white;
        }

        th {
            padding: 10px 8px;
            text-align: left;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9pt;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
        }

        .status-approved {
            background: #dcfce7;
            color: #166534;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .type-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 2px;
            font-size: 8pt;
        }

        .footer {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signatures {
            display: table;
            width: 100%;
            margin-top: 30px;
        }

        .signature-col {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            vertical-align: top;
        }

        .signature-box {
            border: 1px solid #e2e8f0;
            padding: 10px;
            min-height: 80px;
            margin: 0 5px;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 50px;
            color: #475569;
        }

        .signature-name {
            border-top: 1px solid #1e293b;
            padding-top: 5px;
            margin-top: 10px;
        }

        .total-row {
            font-weight: bold;
            background: #f1f5f9 !important;
            border-top: 2px solid #1e293b;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    {{-- HEADER --}}
    <div class="header">
        <h1>Laporan Disposal Aset</h1>
        <h2>Sistem Informasi Manajemen Inventaris</h2>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }} WIB</p>
    </div>

    {{-- SUMMARY --}}
    <div class="summary">
        <h3>Ringkasan Laporan</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-label">Periode Laporan:</div>
                <div class="summary-value">
                    @if(request('start_date') && request('end_date'))
                        {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                    @else
                        Semua Periode
                    @endif
                </div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Total Disposal:</div>
                <div class="summary-value">{{ $disposals->count() }} aset</div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Total Nilai Buku:</div>
                <div class="summary-value">Rp {{ number_format($totalBookValue, 0, ',', '.') }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Dicetak Oleh:</div>
                <div class="summary-value">{{ auth()->user()->name }}</div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode Aset</th>
                <th style="width: 20%;">Nama Aset</th>
                <th style="width: 12%;">Tipe Disposal</th>
                <th style="width: 15%;">Nilai Buku</th>
                <th style="width: 13%;">Tanggal</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Disetujui</th>
            </tr>
        </thead>
        <tbody>
            @forelse($disposals as $index => $disposal)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $disposal->assetDetail->unit_code }}</td>
                    <td>{{ $disposal->assetDetail->inventory->name }}</td>
                    <td>
                        <span class="type-badge">{{ $disposal->disposal_type->label() }}</span>
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($disposal->book_value ?? $disposal->assetDetail->price, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($disposal->approved_at)->format('d/m/Y') }}
                    </td>
                    <td class="text-center">
                        <span class="status-badge status-{{ $disposal->status->value }}">
                            {{ $disposal->status->label() }}
                        </span>
                    </td>
                    <td>{{ $disposal->reviewer->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 30px; color: #94a3b8;">
                        Tidak ada data disposal untuk periode ini
                    </td>
                </tr>
            @endforelse

            @if($disposals->count() > 0)
                <tr class="total-row">
                    <td colspan="4" class="text-right">TOTAL:</td>
                    <td class="text-right">Rp {{ number_format($totalBookValue, 0, ',', '.') }}</td>
                    <td colspan="3"></td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- DETAIL DISPOSAL (Optional, if needed) --}}
    @if($disposals->count() > 0 && $disposals->count() <= 5)
        <div class="page-break"></div>
        <h3 style="margin-top: 0;">Detail Disposal</h3>
        @foreach($disposals as $disposal)
            <div style="margin-bottom: 20px; border: 1px solid #e2e8f0; padding: 15px; border-radius: 4px;">
                <h4 style="margin: 0 0 10px 0; color: #1e293b;">
                    {{ $disposal->assetDetail->unit_code }} - {{ $disposal->assetDetail->inventory->name }}
                </h4>
                <div style="display: table; width: 100%; font-size: 9pt;">
                    <div style="display: table-row;">
                        <div style="display: table-cell; width: 30%; padding: 3px 0; font-weight: bold;">Tipe Disposal:</div>
                        <div style="display: table-cell; padding: 3px 0;">{{ $disposal->disposal_type->label() }}</div>
                    </div>
                    <div style="display: table-row;">
                        <div style="display: table-cell; padding: 3px 0; font-weight: bold;">Alasan:</div>
                        <div style="display: table-cell; padding: 3px 0;">{{ $disposal->reason }}</div>
                    </div>
                    <div style="display: table-row;">
                        <div style="display: table-cell; padding: 3px 0; font-weight: bold;">Diajukan oleh:</div>
                        <div style="display: table-cell; padding: 3px 0;">{{ $disposal->requester->name }}</div>
                    </div>
                    <div style="display: table-row;">
                        <div style="display: table-cell; padding: 3px 0; font-weight: bold;">Disetujui oleh:</div>
                        <div style="display: table-cell; padding: 3px 0;">{{ $disposal->reviewer->name ?? '-' }}</div>
                    </div>
                    @if($disposal->notes)
                        <div style="display: table-row;">
                            <div style="display: table-cell; padding: 3px 0; font-weight: bold;">Catatan Admin:</div>
                            <div style="display: table-cell; padding: 3px 0;">{{ $disposal->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    {{-- SIGNATURES --}}
    <div class="footer">
        <div class="signatures">
            <div class="signature-col">
                <div class="signature-box">
                    <div class="signature-title">Diajukan Oleh</div>
                    <div class="signature-name">
                        Staff Inventaris
                    </div>
                </div>
            </div>
            <div class="signature-col">
                <div class="signature-box">
                    <div class="signature-title">Diperiksa Oleh</div>
                    <div class="signature-name">
                        Kepala Bagian
                    </div>
                </div>
            </div>
            <div class="signature-col">
                <div class="signature-box">
                    <div class="signature-title">Disetujui Oleh</div>
                    <div class="signature-name">
                        Kepala Unit
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER NOTE --}}
    <div
        style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #e2e8f0; font-size: 8pt; color: #94a3b8; text-align: center;">
        Dokumen ini digenerate otomatis oleh Sistem Informasi Manajemen Inventaris<br>
        Tanggal cetak: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }} WIB
    </div>
</body>

</html>