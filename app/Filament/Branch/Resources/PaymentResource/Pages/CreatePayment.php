<?php

namespace App\Filament\Branch\Resources\PaymentResource\Pages;

use App\Filament\Branch\Resources\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function afterCreate(): void
    {
        if ($this->record->status === 'completed') {
            PaymentResource::processPaymentApproval($this->record);
        }
    }
}
