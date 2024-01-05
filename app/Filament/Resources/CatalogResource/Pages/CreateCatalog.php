<?php

namespace App\Filament\Resources\CatalogResource\Pages;

use App\Filament\Resources\CatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCatalog extends CreateRecord
{
    protected static string $resource = CatalogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
