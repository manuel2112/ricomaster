<?php

if (! function_exists('formatMoney')) {
    function formatMoney(int $value): string
    {
        try {
            return '$'.number_format($value, 0, ',', '.');
        } catch (\Throwable $th) {
            return $value;
        }
    }
}
