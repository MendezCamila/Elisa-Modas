<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Auditoría</title>
</head>
<body>
    <h1>Comprobante de Auditoría</h1>

    <p><strong>ID de Auditoría:</strong> {{ $audit->id }}</p>
    <p><strong>Usuario Responsable:</strong> {{ $user_resp->name }} ({{ $user_resp->email }})</p>
    <p><strong>Fecha de Auditoría:</strong> {{ \Carbon\Carbon::parse($audit->created_at)->format('d/m/Y') }}</p>

    <h2>Detalles de la Auditoría</h2>
    <ul>
        @foreach($audit_modified_properties as $key => $value)
            <li><strong>{{ $key }}:</strong>
                @if(is_array($value))
                    <!-- Si el valor es un array, mostramos como JSON -->
                    {{ json_encode($value, JSON_PRETTY_PRINT) }}
                @else
                    <!-- Si es un string o número, lo mostramos normalmente -->
                    {{ htmlspecialchars($value) }}
                @endif
            </li>
        @endforeach
    </ul>
</body>
</html>

