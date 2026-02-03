<?php

namespace App\Filament\Resources\BankTransferPaymentResource\Pages;

use App\Filament\Resources\BankTransferPaymentResource;
use Filament\Resources\Pages\ViewRecord;

class ViewBankTransferPayment extends ViewRecord
{
    protected static string $resource = BankTransferPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\EditAction::make(),
        ];
    }
}
