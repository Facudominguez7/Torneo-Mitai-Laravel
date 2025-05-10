<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Jugadores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }
        .header .team-info {
            text-align: center;
            flex-grow: 1;
        }
        .header .team-info img {
            height: 60px;
            margin-bottom: 10px;
        }
        .header img.logo {
            position: absolute;
            top: 0;
            right: 0;
            height: 80px;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Foto del equipo -->
        <div class="team-info">
            <img src="{{ public_path('fotos/equipos/' . $equipo->foto) }}" alt="Foto del equipo">
            <h2>Equipo: {{ $equipo->nombre }}</h2>
            <h3>{{ $nombreCategoria->nombre }}</h3>
        </div>
        <!-- Logo del torneo -->
        <img class="logo" src="{{ public_path('fotos/Logo_Mitai_SinFondo.png') }}" alt="Logo del torneo">
    </div>
    <h1>Reporte de Jugadores</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Fecha de Nacimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jugadores as $jugador)
                <tr>
                    <td>{{ $jugador->nombre }}</td>
                    <td>{{ $jugador->apellido }}</td>
                    <td>{{ $jugador->dni }}</td>
                    <td>{{ \Carbon\Carbon::parse($jugador->fecha_nacimiento)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>