<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalResource\Pages;
use App\Models\Withdrawal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationLabel = 'Withdrawals';
    protected static ?string $pluralModelLabel = 'Withdrawals';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->disabled() // normally created by user, not admin
                    ->required(),

                Forms\Components\TextInput::make('amount_cents')
                    ->label('Amount (cents)')
                    ->numeric()
                    ->required()
                    ->disabled(), // display-only; user requested this amount

                Forms\Components\TextInput::make('method')
                    ->maxLength(255),

                Forms\Components\TextInput::make('reference')
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending'  => 'Pending',
                        'approved' => 'Approved',
                        'paid'     => 'Paid',
                        'rejected' => 'Rejected',
                        'cancelled'=> 'Cancelled',
                    ])
                    ->required(),

                Forms\Components\DateTimePicker::make('processed_at')
                    ->label('Processed at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount_dollars')
                    ->label('Amount')
                    ->money('usd')
                    ->sortable(),

                Tables\Columns\TextColumn::make('method')
                    ->limit(20),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning'   => 'pending',
                        'success'   => ['approved', 'paid'],
                        'danger'    => 'rejected',
                        'secondary' => 'cancelled',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Requested at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('processed_at')
                    ->label('Processed at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'  => 'Pending',
                        'approved' => 'Approved',
                        'paid'     => 'Paid',
                        'rejected' => 'Rejected',
                        'cancelled'=> 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWithdrawals::route('/'),
            'create' => Pages\CreateWithdrawal::route('/create'),
            'edit' => Pages\EditWithdrawal::route('/{record}/edit'),
        ];
    }
}