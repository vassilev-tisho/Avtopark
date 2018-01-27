
@extends('manager.manager')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>404</title>

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato', sans-serif;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 42px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <br>
        <br>
        <br>
        <br>
        <br><br><br><br><br>
        <div class="title">НИЩО НЕ Е НАМЕРЕНО. СЪЖАЛЯВАМЕ :(</div>
    </div>
</div>
</body>
</html>
@endsection