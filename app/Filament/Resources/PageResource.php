<?php

	namespace App\Filament\Resources;

	use App\Filament\Resources\PageResource\Pages;
	use App\Filament\Resources\PageResource\RelationManagers;
	use App\Models\Page;
	use Filament\Forms;
	use Filament\Forms\Form;
	use Filament\Resources\Resource;
	use Filament\Tables;
	use Filament\Tables\Table;
	use Illuminate\Support\Facades\Storage;

	class PageResource extends Resource {
		protected static ?string $model = Page::class;

		protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
		protected static ?string $label = 'Trang đơn';
		protected static ?int $navigationSort = 3;

		public static function form(Form $form): Form {
			return $form
				->schema([
					Forms\Components\TextInput::make('name')
						->label('Tên trang'),
					Forms\Components\FileUpload::make('image')
						->label('Ảnh trang')
						->disk('public')
						->directory('uploads/')
						->deleteUploadedFileUsing(function ($file) {
							// Xóa file ảnh khi xóa bài viết hoặc cập nhật ảnh bài viết
							Storage::disk('public')
								->delete($file);
						})
						->image()
						->imageEditor()
						->imageEditorAspectRatios([
							'16:9',
							'4:3',
							'1:1',
							'3:4',
							'9:16',
						]),
					Forms\Components\RichEditor::make('content')
						->label('Nội dung')
						->columnSpanFull(),

				]);
		}

		public static function table(Table $table): Table {
			return $table
				->columns([
					Tables\Columns\TextColumn::make('name')
						->label('Tên trang')
						->sortable()
						->searchable(),
					Tables\Columns\ImageColumn::make('image')
						->label('Ảnh trang')
				])
				->filters([
					//
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

		public static function getRelations(): array {
			return [
				//
			];
		}

		public static function getPages(): array {
			return [
				'index' => Pages\ListPages::route('/'),
				'create' => Pages\CreatePage::route('/create'),
				'edit' => Pages\EditPage::route('/{record}/edit'),
			];
		}
	}
