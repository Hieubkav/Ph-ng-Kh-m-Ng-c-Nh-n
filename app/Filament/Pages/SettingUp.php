<?php

    namespace App\Filament\Pages;

    use App\Models\Setting;
    use Filament\Forms;
    use Filament\Pages\Page;
    use Filament\Forms\Form;
    use Filament\Notifications\Notification;
    use Illuminate\Support\Facades\Storage;

    class SettingUp extends Page implements Forms\Contracts\HasForms
    {
        use Forms\Concerns\InteractsWithForms;

        protected static string $view = 'filament.pages.setting-up';

        protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
        protected static ?int $navigationSort = 8;

        protected static ?string $navigationLabel = 'Cài đặt';

        protected static ?string $title = 'Cài đặt';

        public ?array $data = [];

        public Setting $setting;

        public function mount(): void
        {
            $this->setting = Setting::firstOrCreate();
            $this->form->fill($this->setting->toArray());
        }

        public function form(Form $form): Form
        {
            return $form
                ->schema([
                    Forms\Components\Section::make('Thông tin cơ bản')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Tên tổ chức')
                                ->required(),
                            Forms\Components\TextInput::make('hotline')
                                ->tel()
                                ->required(),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required(),
                            Forms\Components\Textarea::make('address')
                                ->label('Địa chỉ')
                                ->required()
                                ->rows(3),
                            Forms\Components\TextInput::make('slogan')
                                ->label('Slogan')
                                ->required(),
                            Forms\Components\TextInput::make('mst')
                                ->label('Mã số thuế')
                                ->required(),
                        ]),

                    Forms\Components\Section::make('Đa phương tiện')
                        ->schema([
                            Forms\Components\FileUpload::make('logo')
                                ->label('Ảnh thương hiệu')
                                ->disk('public')
                                ->directory('uploads/')
                                ->deleteUploadedFileUsing(function ($file) {
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
                            Forms\Components\FileUpload::make('image_schedule')
                                ->label('Ảnh lịch khám bệnh')
                                ->disk('public')
                                ->directory('uploads/')
                                ->deleteUploadedFileUsing(function ($file) {
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
                        ]),

                    Forms\Components\Section::make('Thông tin liên hệ')
                        ->schema([
                            Forms\Components\TextInput::make('zalo')
                                ->label('Số zalo'),
                            Forms\Components\TextInput::make('facebook')
                                ->label('link Facebook'),
                            Forms\Components\TextInput::make('messenger')
                                ->label('link Messenger'),
                            Forms\Components\Textarea::make('google_map')
                                ->label('Code gg map')
                                ->rows(3),
                        ]),

                    Forms\Components\Section::make('Thông tin tuyển dụng')
                        ->schema([
                            Forms\Components\Toggle::make('hr_status')
                                ->label('Trạng thái tuyển dụng')
                                ->default(false),
                            Forms\Components\RichEditor::make('hr_content')
                                ->label('Nội dung tuyển dụng')
                                ->columnSpanFull(),
                        ]),
                ])
                ->statePath('data');
        }

        public function save(): void
        {
            $data = $this->form->getState();
            $this->setting->fill($data)->save();

            Notification::make()
                ->success()
                ->title('Lưu cài đặt thành công')
                ->send();
        }
    }
