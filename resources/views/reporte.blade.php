<h1>Reporte de Items</h1>
{{-- <pre>
    @php
        var_dump($items['data']);
    @endphp
</pre> --}}
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>ID de Compañía</th>
            <th>Fecha de Creación</th>
            <th>Fecha de Actualización</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items['data'] as $item)
            <tr>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['company_id'] }}</td>
                <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($item['updated_at'])->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
