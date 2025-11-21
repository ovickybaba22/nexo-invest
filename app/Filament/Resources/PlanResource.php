<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Invest';
    protected static ?string $navigationLabel = 'Plans';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(60)
                    ->columnSpan(2),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('URL friendly identifier e.g. nexo-daily-starter'),

                Forms\Components\Select::make('category')
                    ->options([
                        'daily' => 'Daily ROI',
                        'weekly' => 'Weekly ROI',
                        'apy' => 'Managed APY',
                    ])
                    ->native(false)
                    ->required()
                    ->columnSpan(1),

                Forms\Components\Select::make('roi_type')
                    ->options([
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'apy' => 'APY (monthly credit)',
                    ])
                    ->native(false)
                    ->required()
                    ->helperText('Determines payout cadence')
                    ->columnSpan(1),

                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('min_deposit')
                    ->label('Minimum deposit (USD)')
                    ->numeric()
                    ->step('0.01')
                    ->prefix('$')
                    // show dollars in the form (DB stores cents)
                    ->formatStateUsing(fn ($state) => is_null($state) ? null : number_format($state / 100, 2, '.', ''))
                    // convert dollars -> cents when saving
                    ->dehydrateStateUsing(fn ($state) => is_null($state) ? null : (int) round(((float) $state) * 100))
                    ->required(),

                Forms\Components\TextInput::make('max_deposit')
                    ->label('Maximum deposit (USD)')
                    ->numeric()
                    ->step('0.01')
                    ->prefix('$')
                    ->formatStateUsing(fn ($state) => is_null($state) ? null : number_format($state / 100, 2, '.', ''))
                    ->dehydrateStateUsing(fn ($state) => is_null($state) ? null : (int) round(((float) $state) * 100))
                    ->nullable(),

                Forms\Components\TextInput::make('term_label')
                    ->label('Term label')
                    ->maxLength(120)
                    ->columnSpan(2),

                Forms\Components\TextInput::make('risk_level')
                    ->label('Risk badge')
                    ->maxLength(40),

                Forms\Components\TextInput::make('min_months')
                    ->label('Minimum months')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(120),

                Forms\Components\TextInput::make('max_months')
                    ->label('Maximum months')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(120)
                    ->nullable(),

                Forms\Components\TextInput::make('roi_value')
                    ->label('ROI % per cycle')
                    ->numeric()
                    ->suffix('%')
                    ->helperText('Daily or weekly percent; for APY this can mirror APY value')
                    ->required(),

                Forms\Components\TextInput::make('apy_value')
                    ->label('APY % (annual)')
                    ->numeric()
                    ->suffix('%')
                    ->helperText('Used for managed portfolios, optional for daily or weekly plans')
                    ->nullable(),

                Forms\Components\TextInput::make('target_roi_percent')
                    ->label('Target ROI % (display)')
                    ->numeric()
                    ->suffix('%')
                    ->required(),

                Forms\Components\TextInput::make('max_roi_percent')
                    ->label('Max ROI %')
                    ->numeric()
                    ->suffix('%')
                    ->nullable(),

                Forms\Components\Repeater::make('features')
                    ->schema([
                        Forms\Components\TextInput::make('value')->label('Feature')->required(),
                    ])
                    ->addActionLabel('Add feature')
                    ->reorderable()
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('risk_level')
                    ->badge()
                    ->sortable()
                    ->label('Risk'),

                Tables\Columns\TextColumn::make('min_deposit')
                    ->label('Min')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => is_null($state) ? '—' : '$' . number_format($state / 100, 2)),

                Tables\Columns\TextColumn::make('max_deposit')
                    ->label('Max')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => is_null($state) ? '—' : '$' . number_format($state / 100, 2)),

                Tables\Columns\TextColumn::make('roi_value')
                    ->label('ROI / cycle')
                    ->formatStateUsing(fn ($state) => $state ? $state . '%' : '—')
                    ->sortable(),

                Tables\Columns\TextColumn::make('apy_value')
                    ->label('APY %')
                    ->formatStateUsing(fn ($state) => $state ? $state . '%' : '—')
                    ->sortable(),

                Tables\Columns\TextColumn::make('target_roi_percent')
                    ->label('Display ROI')
                    ->suffix('%')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->options([
                    'daily' => 'Daily',
                    'weekly' => 'Weekly',
                    'apy' => 'APY',
                ]),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
