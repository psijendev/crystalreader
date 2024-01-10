<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\User;
use App\Models\Document;
use App\Models\Catalog;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '20s';
    protected static bool $isLazy = true;

    protected function getStats(): array
    {


        return [
            Stat::make('Total Documents',Document::count()),
            Stat::make('Total Users',User::count()),
            Stat::make('Total Catalogs',Catalog::count())
        ];
    }
}
