<div>
    <h1>Cliente asociado resumen día {{ \Carbon\Carbon::parse($day)->format('d/m/Y') }}</h1>

    <table style="width: 100%; border-collapse: collapse; margin-top: 30px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th scope="col" style="border: 1px solid black; padding: 8px;">Punto de venta</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Rut cliente</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Cant. menú 1</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Cant. menú 2</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Cant. menú naturista</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Precio menu normal</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Cant. menú especial</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Precio menú especial</th>
                <th scope="col" style="border: 1px solid black; padding: 8px;">Total a facturar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr style="background-color: #f2f2f2;">
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->associated->name }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->associated->rut }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->count_menu_01 }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->count_menu_02 }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->count_menu_naturist }}</td>
                    <td style="border: 1px solid black; padding: 8px;">
                        {{ formatMoney($order->associated->menu_normal_associated) }}
                    </td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $order->count_menu_special }}</td>
                    <td style="border: 1px solid black; padding: 8px;">
                        {{ formatMoney($order->associated->menu_special_associated) }}
                    </td>
                    <td style="border: 1px solid black; padding: 8px;">
                        {{ formatMoney($order->total_price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <html-separator />



    <html-separator />
</div>
