<?php

namespace App\Filament\Branch\Resources\PaymentResource\Pages;

use App\Filament\Branch\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $wasCompleted = $this->record->getOriginal('status') === 'completed';
        $isNowCompleted = $this->record->status === 'completed';

        if (!$wasCompleted && $isNowCompleted) {
            PaymentResource::processPaymentApproval($this->record);
        }
    }
}
