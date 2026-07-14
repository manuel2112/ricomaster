<?php

namespace App\Actions\ClientFinal;

use App\Models\ClientFinal;
use App\Models\OrderFinal;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateMountClientFinal
{
    use AsAction;

    public function handle(): void
    {
        $clients = OrderFinal::query()
            ->selectRaw('client_final_id')
            ->distinct()
            ->groupBy('client_final_id')
            ->orderBy('client_final_id', 'asc')
            ->get();

        ClientFinal::where('mount', '>', 0)->update(['mount' => 0]);

        foreach ($clients as $client) {
            $sum = 0;
            $orders = OrderFinal::where('client_final_id', $client->client_final_id)
                ->whereDate('created_at', '>=', Carbon::now()->subMonth())
                ->get();
            foreach ($orders as $order) {
                $sum += $order->count * $order->price;
            }

            $client = ClientFinal::where('id', $client->client_final_id)->first();

            if ($client) {
                $client->mount = $sum;
                $client->save();
            }
        }
    }
}
