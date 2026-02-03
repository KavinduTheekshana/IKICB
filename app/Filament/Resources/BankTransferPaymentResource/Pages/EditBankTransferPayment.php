<?php

namespace App\Filament\Resources\BankTransferPaymentResource\Pages;

use App\Filament\Resources\BankTransferPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBankTransferPayment extends EditRecord
{
    protected static string $resource = BankTransferPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
