<?php

namespace App\Filament\Branch\Resources\PaymentResource\Pages;

use App\Filament\Branch\Resources\PaymentResource;
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
        $branchId = auth()->user()->branch_id;

        $base = Payment::whereHas('user', fn ($q) => $q->where('branch_id', $branchId));

        return [
            'all' => Tab::make('All')
                ->icon('heroicon-o-queue-list')
                ->badge($base->clone()->count()),

            'pending' => Tab::make('Pending')
                ->icon('heroicon-o-clock')
                ->badgeColor('warning')
                ->badge($base->clone()->where('status', 'pending')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending')),

            'completed' => Tab::make('Completed')
                ->icon('heroicon-o-check-circle')
                ->badgeColor('success')
                ->badge($base->clone()->where('status', 'completed')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),

            'failed' => Tab::make('Failed')
                ->icon('heroicon-o-x-circle')
                ->badgeColor('danger')
                ->badge($base->clone()->where('status', 'failed')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'failed')),

            'refunded' => Tab::make('Refunded')
                ->icon('heroicon-o-arrow-uturn-left')
                ->badgeColor('gray')
                ->badge($base->clone()->where('status', 'refunded')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'refunded')),
        ];
    }
}
