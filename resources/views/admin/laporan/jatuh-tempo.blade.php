<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Jatuh Tempo - SIPUSTAKA</title>
    @include('admin.partials.style')
</head>
<body>
<div class="layout">

    @include('admin.partials.sidebar', ['active' => 'jatuh-tempo'])

    <main class="main">
        <header class="topbar">
            <div class="welcome">
                <h1>Buku Jatuh Tempo</h1>
                <p>Peminjaman yang sudah terlambat atau jatuh tempo dalam tujuh hari ke depan.</p>
            </div>
            <div class="avatar">BS</div>
        </header>

        <div class="content">

            <div class="page-header">
                <div>
                    <h2>Perlu Diperhatikan</h2>
                    <p>Diurutkan dari tanggal jatuh tempo yang paling dekat.</p>
                </div>
                <a href="{{ route('admin.pengembalian.index') }}" class="btn-primary">Proses Pengembalian</a>
            </div>

            <div class="table-card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>NAMA ANGGOTA</th>
                            <th>JUDUL BUKU</th>
                            <th>TGL PINJAM</th>
                            <th>JATUH TEMPO</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($bukuJatuhTempo as $loan)
                        @php
                            $nama = $loan->user->name ?? '-';
                            $tempo = \Illuminate\Support\Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();
                            $selisih = (int) now()->startOfDay()->diffInDays($tempo, false);
                        @endphp
                        <tr>
                            <td>{{ $bukuJatuhTempo->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar">{{ strtoupper(mb_substr($nama, 0, 2)) }}</div>
                                    <div class="book-title" style="margin:0">{{ $nama }}</div>
                                </div>
                            </td>
                            <td>{{ $loan->book->judul_buku ?? '-' }}</td>
                            <td>{{ $loan->tanggal_pinjam ? \Illuminate\Support\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') : '-' }}</td>
                            <td>{{ $tempo->format('d M Y') }}</td>
                            <td>
                                @if($selisih < 0)
                                    <span class="badge badge-empty">Terlambat {{ abs($selisih) }} hari</span>
                                @elseif($selisih === 0)
                                    <span class="badge badge-warning">Jatuh tempo hari ini</span>
                                @else
                                    <span class="badge badge-warning">{{ $selisih }} hari lagi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty-row">Tidak ada peminjaman yang mendekati jatuh tempo.</td></tr>
                    @endforelse
                    </tbody>
                </table>

                @include('admin.partials.pagination', ['paginator' => $bukuJatuhTempo, 'label' => 'peminjaman'])
            </div>
        </div>
    </main>
</div>
</body>
</html>