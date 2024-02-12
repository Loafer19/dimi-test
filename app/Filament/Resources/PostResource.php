<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function canView(Model $record): bool
    {
        return $record->user_id == auth()->id();
    }

    public static function canEdit(Model $record): bool
    {
        return $record->user_id == auth()->id();
    }

    public static function canDelete(Model $record): bool
    {
        return $record->user_id == auth()->id();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('General')->schema([
                Group::make([
                    TextInput::make('title')
                        ->live()
                        ->debounce(200)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', str($state)->slug()))
                        ->required(),
                    TextInput::make('slug')
                        ->required()
                        ->minLength(3),
                ])->columns(2),
                TinyEditor::make('text')
                    ->fileAttachmentsDirectory('posts')
                    ->required(),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('user_id', auth()->id()))
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->limit(50)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
