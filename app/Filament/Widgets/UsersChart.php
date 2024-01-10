<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class UsersChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [
                'label' => 'User Registrations',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ]
             ],
             'labels' => $data->map(fn (TrendValue $value) => $value->date),
            /*
            User::select(DB::raw("COUNT(*) as count"))
            ->whereYear('created_at' ,'=', '2020')
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count')
           */
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
