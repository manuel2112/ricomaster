<div>
    <h1>Cliente final detalle</h1>

    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Nº de Pedido</td>
                <td style="border: 1px solid black; padding: 8px;">{{ $order[0]['order_number'] }}</td>
            </tr>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Fecha del Pedido</td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{ \Carbon\Carbon::parse($order[0]['day_order'])->format('d/m/Y') }}
                </td>
            </tr>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Nombre Cliente</td>
                <td style="border: 1px solid black; padding: 8px;">{{ $order[0]['client_final']['name'] }}</td>
            </tr>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Teléfono Cliente</td>
                <td style="border: 1px solid black; padding: 8px;">{{ $order[0]['client_final']['whatsapp'] }}</td>
            </tr>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Nombre local donde retira</td>
                <td style="border: 1px solid black; padding: 8px;">{{ $order[0]['associated']['name'] }}</td>
            </tr>
            <tr style="background-color: #f2f2f2;">
                <td style="border: 1px solid black; padding: 8px;">Dirección local donde retira</td>
                <td style="border: 1px solid black; padding: 8px;">{{ $order[0]['associated']['address'] }}</td>
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
                    @if (!$is_campaign)
                        <td style="border: 1px solid black; padding: 8px;">{{ $item['type_menu']['name'] }} -
                            {{ $item['menu']['name'] }}</td>
                    @else
                        <td style="border: 1px solid black; padding: 8px;">{{ $item['menu']['name'] }}</td>
                    @endif
                    <td style="border: 1px solid black; padding: 8px;">{{ $item['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <html-separator />
</div>
