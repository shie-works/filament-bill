<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use DeepCopy\Filter\Filter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns;
use Filament\Tables\Filters;
use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $modelLabel = '顧客';

    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\TextInput::make('name')->label('顧客名')->required(),
                Components\Select::make('title')->label('敬称')->options([
                    '御中'=>'御中',
                    '様'=>'様',
                ])->default('御中')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('name')->label('顧客名'),
                Columns\TextColumn::make('title')->label('敬称')
            ])
            ->filters([
                Filters\Filter::make('name')->label('顧客名')
                ->form([
                    Components\TextInput::make('name')->label('顧客名'),
                ])
                ->query(function (Builder $query, $data) {
                    return $query
                        ->when(
                            $data['name'],
                            function(Builder $query, $searchWord){
                                return $query->where('name', 'like', "%{$searchWord}%");
                            }
                        );
                }),
            ],layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(2)
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
