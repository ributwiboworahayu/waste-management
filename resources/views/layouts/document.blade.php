<!DOCTYPE html>
<html>
<head>
    <title>Electrocardiography Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        .container {
            width: 100%;
        }

        .header, .footer {
            text-align: center;
        }

        .header img {
            width: 700px;
        }

        .content {
            margin: 20px 0;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .header {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .right-aligned-table {
            width: 400px;
            margin-left: auto;
            margin-right: 0;
        }

        .right-aligned-table th, .right-aligned-table td {
            padding: 1px;
            text-align: left;
            border: none;
        }

        .table-disable-border th, .table-disable-border td {
            border: none;
            padding: 1px;
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ asset('assets/img/header-dhillon.png') }}" alt="RSU DHILLON">
    </div>
    <div class="content">
        @yield('content')
    </div>
</div>
</body>
</html>
