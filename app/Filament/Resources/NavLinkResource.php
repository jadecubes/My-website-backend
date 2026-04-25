<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavLinkResource\Pages;
use App\Models\NavLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NavLinkResource extends Resource
{
    protected static ?string $model = NavLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'Site';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')
                ->required(),

            Forms\Components\TextInput::make('href')
                ->required(),

            Forms\Components\Toggle::make('is_published')
                ->default(true),

            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('href')->searchable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->reorderable('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavLinks::route('/'),
            'create' => Pages\CreateNavLink::route('/create'),
            'edit' => Pages\EditNavLink::route('/{record}/edit'),
        ];
    }
}
