
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPUSTAKA - Admin')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f5ef;
            color: #17142e;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* =========================
           LAYOUT UTAMA
        ========================= */

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 230px;
            min-height: 100vh;
            background: #19152f;
            color: white;
            padding: 28px 16px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 8px;
            margin-bottom: 55px;
        }

        .brand-logo {
            display: flex;
            align-items: end;
            gap: 3px;
            height: 25px;
        }

        .brand-logo span {
            display: block;
            width: 5px;
            border-radius: 3px;
        }

        .brand-logo span:nth-child(1) {
            height: 14px;
            background: #ff6655;
        }

        .brand-logo span:nth-child(2) {
            height: 21px;
            background: #f6a52e;
        }

        .brand-logo span:nth-child(3) {
            height: 17px;
            background: #14aa99;
        }

        .brand-logo span:nth-child(4) {
            height: 24px;
            background: #7755ef;
        }

        .brand strong {
            font-family: Georgia, serif;
            font-size: 18px;
        }

        .menu-title {
            color: #80799e;
            font-size: 11px;
            margin: 0 10px 12px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 11px 12px;
            border-radius: 10px;
            color: #d5d0e6;
            font-size: 14px;
            font-weight: 600;
        }

        .menu-item:hover {
            background: #292440;
        }

        .menu-item.active {
            background: #ff6655;
            color: white;
        }

        .menu-icon {
            width: 17px;
            text-align: center;
        }

        /* =========================
           AREA KONTEN
        ========================= */

        .main {
            margin-left: 230px;
            width: calc(100% - 230px);
            min-width: 0;
        }

        .topbar {
            min-height: 108px;
            background: white;
            border-bottom: 1px solid #e8e1d5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 30px;
            gap: 16px;
        }

        .welcome h1 {
            font-family: Georgia, serif;
            font-size: 21px;
            margin-bottom: 5px;
        }

        .welcome p {
            color: #8a829b;
            font-size: 13px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #eee8ff;
            color: #6b4ce6;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            flex-shrink: 0;
        }

        .content {
            padding: 28px 30px;
            min-width: 0;
        }

        /* =========================
           HEADER HALAMAN
        ========================= */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 12px;
        }

        .page-header h2 {
            font-family: Georgia, serif;
            font-size: 24px;
            margin-bottom: 6px;
        }

        .page-header p {
            color: #8a829b;
            font-size: 13px;
        }

        .btn-primary {
            border: none;
            background: #ff6655;
            color: white;
            padding: 11px 17px;
            border-radius: 9px;
            font-weight: bold;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-primary:hover {
            background: #f25545;
        }

        /* =========================
           FILTER DAN PENCARIAN
        ========================= */

        .filter-card {
            background: white;
            border: 1px solid #e7e0d4;
            border-radius: 15px;
            padding: 17px;
            margin-bottom: 20px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .search {
            flex: 1;
            min-width: 0;
            height: 42px;
            border: 1px solid #ddd6cc;
            border-radius: 9px;
            padding: 0 14px;
            outline: none;
            background: white;
        }

        .search:focus {
            border-color: #7755ef;
        }

        .btn-filter {
            min-height: 42px;
            padding: 0 17px;
            border: none;
            border-radius: 9px;
            background: #19152f;
            color: white;
            cursor: pointer;
        }

        /* =========================
           TABEL
        ========================= */

        .table-card {
            background: white;
            border: 1px solid #e7e0d4;
            border-radius: 15px;
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #faf8f4;
            color: #8b8393;
            font-size: 10px;
            text-align: left;
            padding: 15px;
            white-space: nowrap;
        }

        .table td {
            padding: 15px;
            font-size: 12px;
            border-top: 1px solid #eee8df;
        }

        .book-title {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .book-author {
            color: #968d9d;
            font-size: 10px;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 9px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-stock {
            background: #def4ee;
            color: #148f7c;
        }

        .badge-empty {
            background: #ffe2dd;
            color: #e75543;
        }

        .badge-role {
            background: #eee8ff;
            color: #6848df;
        }

        .badge-gray {
            background: #efeae0;
            color: #8b8393;
        }

        .action {
            display: flex;
            gap: 7px;
        }

        .btn-small {
            padding: 6px 9px;
            border-radius: 7px;
            font-size: 10px;
            border: none;
            cursor: pointer;
        }

        .btn-edit {
            background: #eee8ff;
            color: #6848df;
        }

        .btn-delete {
            background: #ffe2dd;
            color: #e75543;
        }

        .btn-small:hover {
            opacity: 0.8;
        }

        /* =========================
           PAGINATION
        ========================= */

        .pagination {
            padding: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pagination-info {
            color: #91899a;
            font-size: 11px;
        }

        .pagination-links {
            display: flex;
            gap: 5px;
        }

        .page {
            width: 30px;
            height: 30px;
            border: 1px solid #e0d9cf;
            border-radius: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 11px;
            background: white;
        }

        .page.active {
            background: #ff6655;
            border-color: #ff6655;
            color: white;
        }

        .empty-row {
            text-align: center;
            padding: 40px !important;
            color: #938a9a;
        }

        /* =========================
           USER DAN STATISTIK
        ========================= */

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-cell .avatar {
            width: 34px;
            height: 34px;
            font-size: 11px;
        }

        .stat-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e7e0d4;
            border-radius: 15px;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .stat-card small {
            color: #8a829b;
            font-size: 12px;
        }

        .stat-card strong {
            display: block;
            font-family: Georgia, serif;
            font-size: 30px;
            margin-top: 6px;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        /* =========================
           NOTIFIKASI
        ========================= */

        .flash {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .flash-ok {
            background: #def4ee;
            color: #0f7c6b;
        }

        .flash-err {
            background: #ffe2dd;
            color: #c2412b;
        }

        /* =========================
           MODAL
        ========================= */

        .modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(25, 21, 47, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
            padding: 16px;
        }

        .modal-bg.open {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 15px;
            padding: 26px;
            width: 100%;
            max-width: 440px;
        }

        .modal h3 {
            font-family: Georgia, serif;
            font-size: 21px;
            margin-bottom: 6px;
        }

        .modal label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin: 14px 0 8px;
        }

        .modal input,
        .modal textarea {
            width: 100%;
            border: 1px solid #ddd6cc;
            border-radius: 9px;
            padding: 12px 13px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            outline: none;
            background: #fffdfa;
        }

        .modal input:focus,
        .modal textarea:focus {
            border-color: #7755ef;
        }

        .modal textarea {
            min-height: 90px;
            resize: vertical;
        }

        .modal .hint {
            font-size: 11px;
            color: #8a829b;
            margin-top: 6px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
        }

        .btn-cancel {
            border: 1px solid #ddd6cc;
            background: white;
            color: #55505e;
            padding: 11px 20px;
            border-radius: 9px;
            font-weight: bold;
            cursor: pointer;
            font-size: 13px;
        }

        /* =========================
           HAMBURGER MOBILE
        ========================= */

        .mobile-menu-btn {
            display: none;
            width: 42px;
            height: 42px;
            border: none;
            background: #19152f;
            color: white;
            border-radius: 10px;
            font-size: 24px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-overlay {
            display: none;
        }

        /* =========================
           TABLET
        ========================= */

        @media (max-width: 900px) {
            .content {
                padding: 22px 18px;
            }

            .filter-form {
                flex-wrap: wrap;
            }

            .search {
                flex: 1 1 100%;
            }

            .table-card {
                overflow-x: auto;
            }

            .stat-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 600px) {
            .sidebar {
                width: 260px;
                max-width: 85vw;
                padding: 24px 16px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1001;
                box-shadow: 5px 0 25px rgba(0, 0, 0, 0.15);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .brand {
                justify-content: flex-start;
                margin-bottom: 35px;
            }

            .brand strong,
            .menu-title,
            .menu-item span:not(.menu-icon) {
                display: initial;
            }

            .menu-item {
                justify-content: flex-start;
                padding: 12px;
            }

            .main {
                margin-left: 0;
                width: 100%;
                min-width: 0;
            }

            .topbar {
                min-height: 75px;
                padding: 12px 16px;
                gap: 10px;
            }

            .mobile-menu-btn {
                display: flex;
                order: 3;
            }

            .welcome {
                flex: 1;
                min-width: 0;
            }

            .welcome h1 {
                font-size: 16px;
            }

            .welcome p {
                font-size: 11px;
            }

            .avatar {
                width: 34px;
                height: 34px;
            }

            .content {
                padding: 18px 12px;
                width: 100%;
                overflow-x: hidden;
            }

            .page-header {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .page-header h2 {
                font-size: 21px;
            }

            .page-header p {
                font-size: 12px;
            }

            .stat-row {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 16px;
            }

            .filter-card {
                padding: 12px;
            }

            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search,
            .btn-filter {
                width: 100%;
            }

            .table-card {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 650px;
            }

            .modal {
                padding: 20px;
            }

            .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(15, 12, 30, 0.55);
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            .sidebar-overlay.active {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>

<body>
    @yield('content')
</body>
</html>
