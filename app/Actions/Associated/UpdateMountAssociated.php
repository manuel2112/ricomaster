<?php

namespace App\Actions\Associated;

use App\Models\Associated;
use App\Models\OrderAssociated;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateMountAssociated
{
    use AsAction;

    public function handle(): void
    {
        $associateds = OrderAssociated::query()
            ->selectRaw('associated_id')
            ->distinct()
            ->groupBy('associated_id')
            ->orderBy('associated_id', 'asc')
            ->get();

        Associated::where('mount', '>', 0)->update(['mount' => 0]);

        foreach ($associateds as $associated) {
            $sum = 0;
            $orders = OrderAssociated::where('associated_id', $associated->associated_id)
                ->whereDate('created_at', '>=', Carbon::now()->subMonth())
                ->get();
            foreach ($orders as $order) {
                $sum += $order->count * $order->price;
            }

            $associatedModel = Associated::where('id', $associated->associated_id)->first();

            if ($associatedModel) {
                $associatedModel->mount = $sum;
                $associatedModel->save();
            }
        }
    }
}
