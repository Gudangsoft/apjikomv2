<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #1f2937; margin: 0; padding: 0; }
    h1 { font-size: 14px; margin: 0 0 4px; color: #1e3a5f; }
    .meta { font-size: 8px; color: #6b7280; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    thead tr { background: #1e3a5f; color: white; }
    thead th { padding: 5px 4px; text-align: left; font-weight: 600; font-size: 8px; }
    tbody tr:nth-child(even) { background: #f3f4f6; }
    tbody td { padding: 4px; border-bottom: 1px solid #e5e7eb; font-size: 8px; }
    .badge-active { background: #d1fae5; color: #065f46; padding: 1px 5px; border-radius: 9px; font-size: 7px; }
    .badge-inactive { background: #fee2e2; color: #991b1b; padding: 1px 5px; border-radius: 9px; font-size: 7px; }
    .footer { margin-top: 12px; font-size: 8px; color: #9ca3af; text-align: right; }
    .summary { margin-bottom: 8px; display: flex; gap: 16px; }
    .sum-item { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 4px; padding: 4px 10px; }
    .sum-label { font-size: 7px; color: #3b82f6; }
    .sum-value { font-size: 12px; font-weight: bold; color: #1e3a5f; }
</style>
</head>
<body>
<h1>Laporan Data Anggota {{ $siteName }}</h1>
<div class="meta">Diekspor pada: {{ now()->format('d/m/Y H:i:s') }} &nbsp;|&nbsp; Total: {{ $members->count() }} anggota</div>

<table style="width:auto; border:none; margin-bottom:8px;">
    <tr>
        <td style="border:1px solid #bfdbfe; background:#eff6ff; border-radius:4px; padding:4px 10px; margin-right:8px;">
            <div style="font-size:7px;color:#3b82f6;">Total Anggota</div>
            <div style="font-size:12px;font-weight:bold;color:#1e3a5f;">{{ $members->count() }}</div>
        </td>
        <td style="width:8px;"></td>
        <td style="border:1px solid #bbf7d0; background:#f0fdf4; border-radius:4px; padding:4px 10px;">
            <div style="font-size:7px;color:#16a34a;">Anggota Aktif</div>
            <div style="font-size:12px;font-weight:bold;color:#14532d;">{{ $members->where('status','active')->count() }}</div>
        </td>
        <td style="width:8px;"></td>
        <td style="border:1px solid #fde68a; background:#fffbeb; border-radius:4px; padding:4px 10px;">
            <div style="font-size:7px;color:#d97706;">Anggota Institusi</div>
            <div style="font-size:12px;font-weight:bold;color:#92400e;">{{ $members->where('member_type','institution')->count() }}</div>
        </td>
        <td style="width:8px;"></td>
        <td style="border:1px solid #e9d5ff; background:#f5f3ff; border-radius:4px; padding:4px 10px;">
            <div style="font-size:7px;color:#7c3aed;">Anggota Perorangan</div>
            <div style="font-size:12px;font-weight:bold;color:#4c1d95;">{{ $members->where('member_type','individual')->count() }}</div>
        </td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>No Anggota</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Institusi</th>
            <th>Tipe</th>
            <th>Status</th>
            <th>Bergabung</th>
            <th>Expired</th>
        </tr>
    </thead>
    <tbody>
        @foreach($members as $i => $member)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $member->member_number ?? '-' }}</td>
            <td>{{ $member->user->name ?? '-' }}</td>
            <td>{{ $member->user->email ?? '-' }}</td>
            <td>{{ $member->phone ?? '-' }}</td>
            <td>{{ $member->institution_name ?? '-' }}</td>
            <td>{{ $member->member_type === 'institution' ? 'Institusi' : 'Perorangan' }}</td>
            <td>
                @if($member->status === 'active')
                <span class="badge-active">Aktif</span>
                @else
                <span class="badge-inactive">{{ ucfirst($member->status) }}</span>
                @endif
            </td>
            <td>{{ $member->join_date ? $member->join_date->format('d/m/Y') : '-' }}</td>
            <td>{{ $member->expiry_date ? $member->expiry_date->format('d/m/Y') : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">{{ $siteName }} &mdash; {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
