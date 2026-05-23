<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #0f172a;
            font-size: 11px;
        }

        .header {
            background: #0f172a;
            color: white;
            padding: 22px;
            border-radius: 18px;
            margin-bottom: 18px;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            object-fit: cover;
            float: left;
            margin-right: 18px;
        }

        .title {
            font-size: 26px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle {
            color: #bae6fd;
            margin-top: 6px;
        }

        .summary {
            width: 100%;
            margin-bottom: 18px;
        }

        .summary td {
            width: 20%;
            padding: 14px;
            border-radius: 14px;
            background: #f1f5f9;
            text-align: center;
        }

        .summary .number {
            font-size: 24px;
            font-weight: bold;
            margin-top: 5px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background: #e0f2fe;
            color: #0369a1;
            padding: 10px;
            text-align: left;
            font-size: 10px;
        }

        table.data td {
            padding: 9px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .photo {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            object-fit: cover;
        }

        .badge {
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: bold;
        }

        .present { background: #dcfce7; color: #15803d; }
        .late { background: #fef3c7; color: #b45309; }
        .leave { background: #dbeafe; color: #1d4ed8; }
        .sick { background: #f3e8ff; color: #7e22ce; }
        .absent { background: #fee2e2; color: #b91c1c; }

        .footer {
            margin-top: 35px;
            width: 100%;
        }

        .signature {
            width: 280px;
            float: right;
            text-align: center;
        }

        .signature-box {
            margin-top: 45px;
            border-top: 1px solid #0f172a;
            padding-top: 8px;
            font-weight: bold;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('images/logo-company.jpeg') }}" class="logo">

        <p class="title">Laporan Absensi Karyawan</p>
        <p class="subtitle">HUBASO Smart Attendance System</p>
        <p class="subtitle">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>

        <div class="clear"></div>
    </div>

    <table class="summary">
        <tr>
            <td>
                <div>Hadir</div>
                <div class="number">{{ $summary['present'] }}</div>
            </td>
            <td>
                <div>Terlambat</div>
                <div class="number">{{ $summary['late'] }}</div>
            </td>
            <td>
                <div>Izin</div>
                <div class="number">{{ $summary['leave'] }}</div>
            </td>
            <td>
                <div>Sakit</div>
                <div class="number">{{ $summary['sick'] }}</div>
            </td>
            <td>
                <div>Alpha</div>
                <div class="number">{{ $summary['absent'] }}</div>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>Karyawan</th>
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>Foto Masuk</th>
                <th>Pulang</th>
                <th>Foto Pulang</th>
                <th>Terlambat</th>
                <th>Jarak</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($attendances as $attendance)
                <tr>
                    <td>
                        <strong>{{ $attendance->employee?->name ?? '-' }}</strong><br>
                        {{ $attendance->employee?->employee_code ?? '-' }}
                    </td>

                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>

                    <td>{{ $attendance->check_in ?? '-' }}</td>

                    <td>
                        @if ($attendance->check_in_photo && file_exists(public_path($attendance->check_in_photo)))
                            <img src="{{ public_path($attendance->check_in_photo) }}" class="photo">
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $attendance->check_out ?? '-' }}</td>

                    <td>
                        @if ($attendance->check_out_photo && file_exists(public_path($attendance->check_out_photo)))
                            <img src="{{ public_path($attendance->check_out_photo) }}" class="photo">
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $attendance->late_minutes }} menit</td>

                    <td>
                        {{ $attendance->distance_from_office ? $attendance->distance_from_office . ' m' : '-' }}
                    </td>

                    <td>
                        @if ($attendance->status === 'present')
                            <span class="badge present">Hadir</span>
                        @elseif ($attendance->status === 'late')
                            <span class="badge late">Terlambat</span>
                        @elseif ($attendance->status === 'leave')
                            <span class="badge leave">Izin</span>
                        @elseif ($attendance->status === 'sick')
                            <span class="badge sick">Sakit</span>
                        @else
                            <span class="badge absent">Alpha</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:30px;">
                        Data tidak ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p>HR / Administrator</p>

            <div class="signature-box">
                {{ Auth::user()->name ?? 'Administrator' }}
            </div>
        </div>
    </div>

</body>
</html>