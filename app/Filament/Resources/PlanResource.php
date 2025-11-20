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
                    ->maxLength(50)
                    ->columnSpan(2),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('e.g. core, growth, private, institutional'),

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

                Forms\Components\TextInput::make('min_months')
                    ->label('Minimum months')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(120)
                    ->required(),

                Forms\Components\TextInput::make('max_months')
                    ->label('Maximum months')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(120)
                    ->nullable(),

                Forms\Components\TextInput::make('target_roi_percent')
                    ->label('Target ROI %')
                    ->numeric()
                    ->suffix('%')
                    ->required(),

                Forms\Components\TextInput::make('max_roi_percent')
                    ->label('Max ROI %')
                    ->numeric()
                    ->suffix('%')
                    ->nullable(),

                Forms\Components\Select::make('risk_level')
                    ->options([
                        'Core' => 'Core',
                        'Balanced' => 'Balanced',
                        'Growth' => 'Growth',
                    ])
                    ->native(false)
                    ->required(),

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
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('risk_level')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('min_deposit')
                    ->label('Min')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => is_null($state) ? '—' : '$' . number_format($state / 100, 2)),

                Tables\Columns\TextColumn::make('max_deposit')
                    ->label('Max')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => is_null($state) ? '—' : '$' . number_format($state / 100, 2)),

                Tables\Columns\TextColumn::make('min_months')
                    ->label('Min m')
                    ->sortable(),

                Tables\Columns\TextColumn::make('max_months')
                    ->label('Max m')
                    ->sortable(),

                Tables\Columns\TextColumn::make('target_roi_percent')
                    ->label('Target ROI')
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
                Tables\Filters\SelectFilter::make('risk_level')->options([
                    'Core' => 'Core',
                    'Balanced' => 'Balanced',
                    'Growth' => 'Growth',
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
