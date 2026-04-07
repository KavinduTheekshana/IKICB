<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\Payment;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->icon('heroicon-o-queue-list')
                ->badge(Payment::count()),

            'pending' => Tab::make('Pending')
                ->icon('heroicon-o-clock')
                ->badgeColor('warning')
                ->badge(Payment::where('status', 'pending')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending')),

            'completed' => Tab::make('Completed')
                ->icon('heroicon-o-check-circle')
                ->badgeColor('success')
                ->badge(Payment::where('status', 'completed')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),

            'failed' => Tab::make('Failed')
                ->icon('heroicon-o-x-circle')
                ->badgeColor('danger')
                ->badge(Payment::where('status', 'failed')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'failed')),

            'refunded' => Tab::make('Refunded')
                ->icon('heroicon-o-arrow-uturn-left')
                ->badgeColor('gray')
                ->badge(Payment::where('status', 'refunded')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'refunded')),
        ];
    }
}
