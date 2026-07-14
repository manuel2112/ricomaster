<div>
    <h1>Cliente asociado detalle</h1>

    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Fecha del Pedido</td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{ \Carbon\Carbon::parse($order[0]['day_order'])->format('d/m/Y') }}
                </td>
            </tr>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Nombre del Local</td>
                <td style="border: 1px solid black; padding: 8px;">{{ $order[0]['associated']['name'] }}</td>
            </tr>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Teléfono contacto del local</td>
                <td style="border: 1px solid black; padding: 8px;">+56{{ $order[0]['associated']['whatsapp'] }}</td>
            </tr>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Rut Comercio Asociado</td>
                <td style="border: 1px solid black; padding: 8px;">{{ $order[0]['associated']['rut'] }}</td>
            </tr>
        </tbody>
    </table>

    <html-separator />

    <table style="width: 100%; border-collapse: collapse; margin-top: 30px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th scope="col" style="border: 1px solid black; padding: 8px;">Opciones</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order as $item)
                <tr style="background-color: #f2f2f2;">
                    <td style="border: 1px solid black; padding: 8px;">{{ $item['type_menu']['name'] }} -
                        {{ $item['menu']['name'] }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $item['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <html-separator />
</div>
