<?php

namespace App\Filament\Resources\BankTransferPaymentResource\Pages;

use App\Filament\Resources\BankTransferPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBankTransferPayment extends CreateRecord
{
    protected static string $resource = BankTransferPaymentResource::class;
}
