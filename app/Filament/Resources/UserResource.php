<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $modelLabel = 'ユーザー';
    protected static ?string $model = User::class;
    // protected static ?string $navigationGroup = '管理';
    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\TextInput::make('name')->label('名前')->required(),
                Components\TextInput::make('email')->label('メールアドレス')
                    ->required()
                    ->email()
                    //オートコンプリートを無効にする
                    ->autocomplete(false),
                Components\TextInput::make('password')->label('パスワード')
                    //オートコンプリートを無効にする
                    ->autocomplete(false)
                    //パスワードの入力だとわかるようにする
                    ->password()
                    //保存時にハッシュ加されたパスワードを送る
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    //パスワードの入力が無い時は何もしない
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    //新規作成時だけ必須
                    ->required(fn (string $operation): bool => $operation === 'create')
                    //半角英数字記号それぞれ1文字以上使用し、8文字以上かどうか
                    ->regex('/\A(?=.*?[a-z])(?=.*?\d)(?=.*?[!-\/:-@[-`{-~])[!-~]{8,}+\z/i')
                    //エラー文
                    ->validationMessages([
                        'regex' => ':attributeは半角英数字記号それぞれ1文字以上使用した8文字以上で指定してください',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('name')->label('名前')
                    //検索対象にする
                    ->searchable()
                    //sort可能にする
                    ->sortable(),
                Columns\TextColumn::make('email')->label('メールアドレス')
                    ->searchable()
            ])
            ->filters([])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
