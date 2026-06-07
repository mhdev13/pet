<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Vaksin - {{ $pet->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1f2937; background: #fff; }

        /* Header */
        .header { background: linear-gradient(135deg, #1d4ed8 0%, #4f46e5 100%); color: #fff; padding: 28px 32px; }
        .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .header-title { font-size: 22px; font-weight: 700; letter-spacing: 0.5px; }
        .header-sub { font-size: 12px; opacity: 0.8; margin-top: 4px; }
        .header-date { font-size: 10px; opacity: 0.7; text-align: right; }

        /* Pet info */
        .pet-card { margin: 24px 32px 0; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px 24px; }
        .pet-card-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: 12px; }
        .pet-grid { display: table; width: 100%; }
        .pet-row { display: table-row; }
        .pet-cell { display: table-cell; width: 25%; padding-bottom: 8px; vertical-align: top; }
        .pet-label { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .pet-value { font-size: 12px; font-weight: 600; color: #1e293b; margin-top: 2px; }

        /* Section */
        .section { margin: 24px 32px 0; }
        .section-title { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 2px solid #e2e8f0; }

        /* Vaccine card */
        .vaccine-card { border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 12px; overflow: hidden; }
        .vaccine-header { background: #f1f5f9; padding: 10px 16px; display: flex; justify-content: space-between; align-items: center; }
        .vaccine-number { width: 24px; height: 24px; border-radius: 50%; background: #2563eb; color: #fff; font-size: 10px; font-weight: 700; text-align: center; line-height: 24px; display: inline-block; margin-right: 10px; }
        .vaccine-name { font-size: 13px; font-weight: 700; color: #1e293b; }
        .badge { display: inline-block; font-size: 9px; font-weight: 600; padding: 2px 8px; border-radius: 20px; }
        .badge-red { background: #fee2e2; color: #dc2626; }
        .badge-yellow { background: #fef9c3; color: #ca8a04; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .vaccine-body { padding: 12px 16px; }
        .vaccine-grid { display: table; width: 100%; }
        .vaccine-row { display: table-row; }
        .vaccine-cell { display: table-cell; width: 25%; padding-right: 12px; vertical-align: top; padding-bottom: 6px; }
        .field-label { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .field-value { font-size: 11px; font-weight: 500; color: #374151; margin-top: 2px; }
        .field-value.danger { color: #dc2626; }
        .notes-box { margin-top: 8px; padding: 8px 10px; background: #f8fafc; border-left: 3px solid #94a3b8; border-radius: 0 4px 4px 0; font-size: 10px; color: #6b7280; font-style: italic; }

        /* Empty state */
        .empty { text-align: center; padding: 40px; color: #94a3b8; font-size: 12px; }

        /* Footer */
        .footer { margin: 32px 32px 0; padding: 16px 0; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .footer-left { font-size: 9px; color: #94a3b8; }
        .footer-right { font-size: 9px; color: #94a3b8; text-align: right; }

        /* Summary bar */
        .summary { margin: 20px 32px 0; display: table; width: calc(100% - 64px); }
        .summary-item { display: table-cell; text-align: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; }
        .summary-item + .summary-item { margin-left: 12px; }
        .summary-number { font-size: 22px; font-weight: 700; color: #1e293b; }
        .summary-label { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div class="header-top">
            <div>
                <div class="header-title">Buku Vaksin Hewan Peliharaan</div>
                <div class="header-sub">{{ config('app.name') }}</div>
            </div>
            <div class="header-date">
                Dicetak pada<br>{{ now()->isoFormat('D MMMM Y') }}
            </div>
        </div>
    </div>

    {{-- Pet info --}}
    <div class="pet-card">
        <div class="pet-card-title">Informasi Hewan</div>
        <div class="pet-grid">
            <div class="pet-row">
                <div class="pet-cell">
                    <div class="pet-label">Nama</div>
                    <div class="pet-value">{{ $pet->name }}</div>
                </div>
                <div class="pet-cell">
                    <div class="pet-label">Jenis</div>
                    <div class="pet-value">{{ $pet->type }}</div>
                </div>
                <div class="pet-cell">
                    <div class="pet-label">Ras</div>
                    <div class="pet-value">{{ $pet->breed ?? '-' }}</div>
                </div>
                <div class="pet-cell">
                    <div class="pet-label">Kelamin</div>
                    <div class="pet-value">{{ $pet->gender === 'male' ? 'Jantan' : 'Betina' }}</div>
                </div>
            </div>
            <div class="pet-row">
                <div class="pet-cell">
                    <div class="pet-label">Umur</div>
                    <div class="pet-value">{{ $pet->age ? $pet->age . ' tahun' : '-' }}</div>
                </div>
                <div class="pet-cell">
                    <div class="pet-label">Status</div>
                    <div class="pet-value">{{ $pet->is_active ? 'Aktif' : 'Tidak Aktif' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary --}}
    @php
        $overdue  = $vaccines->filter(fn($v) => $v->next_vaccine_date && $v->next_vaccine_date->isPast())->count();
        $upcoming = $vaccines->filter(fn($v) => $v->next_vaccine_date && !$v->next_vaccine_date->isPast() && $v->next_vaccine_date->diffInDays(now()) <= 30)->count();
    @endphp
    <div style="margin: 16px 32px 0; display: table; width: calc(100% - 64px);">
        <div style="display: table-cell; width: 33%; text-align: center; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px;">
            <div style="font-size: 22px; font-weight: 700; color: #1d4ed8;">{{ $vaccines->count() }}</div>
            <div style="font-size: 9px; color: #3b82f6; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;">Total Vaksin</div>
        </div>
        <div style="display: table-cell; width: 4px;"></div>
        <div style="display: table-cell; width: 33%; text-align: center; background: #fef9c3; border: 1px solid #fde047; border-radius: 8px; padding: 12px;">
            <div style="font-size: 22px; font-weight: 700; color: #ca8a04;">{{ $upcoming }}</div>
            <div style="font-size: 9px; color: #ca8a04; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;">Jadwal Segera</div>
        </div>
        <div style="display: table-cell; width: 4px;"></div>
        <div style="display: table-cell; width: 33%; text-align: center; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 12px;">
            <div style="font-size: 22px; font-weight: 700; color: #dc2626;">{{ $overdue }}</div>
            <div style="font-size: 9px; color: #dc2626; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;">Terlambat</div>
        </div>
    </div>

    {{-- Vaccine records --}}
    <div class="section">
        <div class="section-title">Riwayat Vaksinasi</div>

        @if($vaccines->isEmpty())
            <div class="empty">Belum ada riwayat vaksinasi.</div>
        @else
            @foreach($vaccines as $i => $vaccine)
                @php
                    $isOverdue  = $vaccine->next_vaccine_date && $vaccine->next_vaccine_date->isPast();
                    $isUpcoming = $vaccine->next_vaccine_date && !$isOverdue && $vaccine->next_vaccine_date->diffInDays(now()) <= 30;
                @endphp
                <div class="vaccine-card">
                    <div class="vaccine-header">
                        <div>
                            <span class="vaccine-number">{{ $vaccines->count() - $i }}</span>
                            <span class="vaccine-name">{{ $vaccine->vaccine_name }}</span>
                        </div>
                        @if($isOverdue)
                            <span class="badge badge-red">Jadwal Terlewat</span>
                        @elseif($isUpcoming)
                            <span class="badge badge-yellow">Segera</span>
                        @elseif($vaccine->next_vaccine_date)
                            <span class="badge badge-green">Terjadwal</span>
                        @endif
                    </div>
                    <div class="vaccine-body">
                        <div class="vaccine-grid">
                            <div class="vaccine-row">
                                <div class="vaccine-cell">
                                    <div class="field-label">Tanggal Vaksin</div>
                                    <div class="field-value">{{ $vaccine->vaccine_date->format('d M Y') }}</div>
                                </div>
                                <div class="vaccine-cell">
                                    <div class="field-label">Vaksin Berikutnya</div>
                                    <div class="field-value {{ $isOverdue ? 'danger' : '' }}">
                                        {{ $vaccine->next_vaccine_date?->format('d M Y') ?? '-' }}
                                    </div>
                                </div>
                                <div class="vaccine-cell">
                                    <div class="field-label">Dokter / Petugas</div>
                                    <div class="field-value">{{ $vaccine->administered_by ?? '-' }}</div>
                                </div>
                                <div class="vaccine-cell">
                                    <div class="field-label">Klinik</div>
                                    <div class="field-value">{{ $vaccine->clinic ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        @if($vaccine->notes)
                            <div class="notes-box">{{ $vaccine->notes }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Footer --}}
    <div class="footer">
        <div class="footer-left">
            {{ config('app.name') }} · Dokumen ini digenerate secara otomatis
        </div>
        <div class="footer-right">
            {{ $pet->name }} · Buku Vaksin
        </div>
    </div>

</body>
</html>
