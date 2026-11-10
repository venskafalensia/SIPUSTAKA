<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian - SIPUSTAKA</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #243247;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            color: #173b70;
        }

        .subtitle {
            color: #64748b;
        }

        .button {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 8px;
            background: #244f91;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .search-box,
        .card {
            background: white;
            padding: 22px;
            margin-bottom: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        }

        .search-form {
            display: flex;
            gap: 10px;
        }

        input {
            flex: 1;
            min-width: 0;
            padding: 12px;
            border: 1px solid #d5deea;
            border-radius: 8px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e8edf4;
            text-align: left;
        }

        th {
            background: #eef4fc;
            color: #244f91;
        }

        .empty {
            padding: 20px;
            color: #64748b;
            text-align: center;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .search-form {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Pencarian SIPUSTAKA</h1>
            <div class="subtitle">
                Cari data buku dan anggota perpustakaan.
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="button">
            Kembali ke Dashboard
        </a>
    </div>

    <div class="search-box">
        <form action="{{ route('admin.search') }}"
              method="GET"
              class="search-form">

            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Cari judul buku, pengarang, ISBN, atau anggota..."
            >

            <button type="submit" class="button">Cari</button>
        </form>
    </div>

    <div class="card">
        <h2>Hasil Pencarian Buku</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>ISBN</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $books->firstItem() + $loop->index }}</td>
                        <td>{{ $book->judul_buku }}</td>
                        <td>{{ $book->pengarang }}</td>
                        <td>{{ $book->penerbit ?? '-' }}</td>
                        <td>{{ $book->isbn ?? '-' }}</td>
                        <td>{{ $book->kategori ?? '-' }}</td>
                        <td>{{ $book->stok }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">
                            Tidak ada buku yang ditemukan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $books->links() }}
    </div>

    <div class="card">
        <h2>Hasil Pencarian Anggota</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $users->firstItem('anggota_page') + $loop->index }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email ?? '-' }}</td>
                        <td>{{ $user->role }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Tidak ada anggota yang ditemukan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->appends(['q' => $q])->links() }}
    </div>

</div>
</body>
</html>