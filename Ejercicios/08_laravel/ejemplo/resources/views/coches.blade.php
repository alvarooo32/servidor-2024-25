<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coches</title>
</head>
<body>
    <h1>Lista de coches</h1>
    <ol>
        @foreach ($coches as $coche)
            <tr>
                <td>{{$coche[1]}} {{$coche[0]}}</td>
                <td>{{$coche[2]}}</td>
            </tr>
        @endforeach
    </ol>
</body>
</html>