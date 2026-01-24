<?php

namespace App\Exports;

use App\Models\Member;

class MembersExport
{
    protected $members;

    public function __construct($members)
    {
        $this->members = $members;
    }

    /**
     * Export members as Excel file with proper formatting
     */
    public function export($filename)
    {
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.xls"',
            'Cache-Control' => 'max-age=0',
        ];

        $callback = function() {
            // Create Excel-compatible HTML format
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            
            // Summary statistics
            $totalMembers = $this->members->count();
            $activeMembers = $this->members->where('status', 'active')->count();
            $verifiedMembers = $this->members->where('is_verified', true)->count();
            $membersWithCity = $this->members->whereNotNull('city')->where('city', '!=', '')->count();
            
            echo '<h2>Laporan Data Anggota APJIKOM</h2>';
            echo '<p>Diekspor pada: ' . date('d/m/Y H:i:s') . '</p>';
            echo '<br>';
            
            echo '<table border="1" style="margin-bottom: 20px;">';
            echo '<tr><td style="font-weight: bold;">Total Anggota</td><td>' . $totalMembers . '</td></tr>';
            echo '<tr><td style="font-weight: bold;">Anggota Aktif</td><td>' . $activeMembers . '</td></tr>';
            echo '<tr><td style="font-weight: bold;">Anggota Terverifikasi</td><td>' . $verifiedMembers . '</td></tr>';
            echo '<tr><td style="font-weight: bold;">Anggota dengan Info Kota</td><td>' . $membersWithCity . '</td></tr>';
            echo '</table>';
            
            echo '<br>';
            echo '<h3>Detail Anggota</h3>';
            
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr style="background-color: #f0f0f0; font-weight: bold;">';
            echo '<th>No Anggota</th>';
            echo '<th>Nama Lengkap</th>';
            echo '<th>Email</th>';
            echo '<th>Telepon</th>';
            echo '<th>Institusi</th>';
            echo '<th>Posisi</th>';
            echo '<th>Kota</th>';
            echo '<th>Provinsi</th>';
            echo '<th>Alamat</th>';
            echo '<th>Status</th>';
            echo '<th>Verifikasi</th>';
            echo '<th>Tanggal Bergabung</th>';
            echo '<th>Tipe Member</th>';
            echo '<th>Website</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            foreach ($this->members as $member) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($member->member_number ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($member->user->name ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($member->user->email ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($member->phone ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($member->institution_name ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($member->position ?? '-') . '</td>';
                echo '<td style="background-color: ' . ($member->city ? '#e8f5e8' : '#fff5f5') . ';">' . htmlspecialchars($member->city ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($member->province ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($member->address ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars(ucfirst($member->status)) . '</td>';
                echo '<td>' . htmlspecialchars($member->is_verified ? 'Terverifikasi' : 'Belum Verifikasi') . '</td>';
                echo '<td>' . htmlspecialchars($member->join_date ? $member->join_date->format('d/m/Y') : '-') . '</td>';
                echo '<td>' . htmlspecialchars(ucfirst($member->member_type)) . '</td>';
                echo '<td>' . htmlspecialchars($member->website ?? '-') . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
        };

        return response()->stream($callback, 200, $headers);
    }
}