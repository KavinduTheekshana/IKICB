<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['currency'] = 'LKR';
        return $data;
    }

    protected function afterCreate(): void
    {
        $payment = $this->record;

        if ($payment->status === 'completed') {
            PaymentResource::handlePaymentCompleted($payment);
        }
    }
}
