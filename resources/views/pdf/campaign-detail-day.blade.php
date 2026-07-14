<div>
    <h1>Cliente final resumen día {{ \Carbon\Carbon::parse($day)->format('d/m/Y') }}</h1>

    <table style="width: 100%; border-collapse: collapse; margin-top: 30px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th scope="col" style="border: 1px solid black; padding: 8px;">Código cliente</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Punto de venta</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Cliente</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Menú</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Cantidad</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Precio unitario</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Total a facturar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr style="background-color: #f2f2f2;">
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->client_final_id }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->associated->name }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->client_final->name }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->menu->name }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->count }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ formatMoney($order->price / $order->count) }}
                    </td>
                    <td style="border: 1px solid black; padding: 8px;">
                        {{ formatMoney($order->price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <html-separator />



    <html-separator />
</div>
