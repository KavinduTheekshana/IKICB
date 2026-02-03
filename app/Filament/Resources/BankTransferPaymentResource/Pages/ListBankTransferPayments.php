<?php

namespace App\Filament\Resources\BankTransferPaymentResource\Pages;

use App\Filament\Resources\BankTransferPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBankTransferPayments extends ListRecords
{
    protected static string $resource = BankTransferPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
