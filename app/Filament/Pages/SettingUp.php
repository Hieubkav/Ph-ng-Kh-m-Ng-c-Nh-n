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

        protected static ?string $navigationLabel = 'Thông tin chung';

        protected static ?string $title = 'Thông tin chung';

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
                    Forms\Components\Tabs::make('Cài đặt')
                        ->tabs([
                            Forms\Components\Tabs\Tab::make('Thông tin cơ bản')
                                ->icon('heroicon-o-information-circle')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Tên tổ chức')
                                        ->required()
                                        ->columnSpan(2),
                                    Forms\Components\Grid::make(2)
                                        ->columnSpan(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('hotline')
                                                ->tel()
                                                ->required(),
                                            Forms\Components\TextInput::make('email')
                                                ->email()
                                                ->required(),
                                        ]),
                                    Forms\Components\Textarea::make('address')
                                        ->label('Địa chỉ')
                                        ->required()
                                        ->rows(3)
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('slogan')
                                        ->label('Slogan')
                                        ->required()
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('mst')
                                        ->label('Mã số thuế')
                                        ->required()
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('giay_phep')
                                        ->label('Giấy phép kinh doanh')
                                        ->required()
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('telephone')
                                        ->label('Điện thoại')
                                        ->tel()
                                        ->required()
                                        ->columnSpan(2),
                                ]),
                            
                            Forms\Components\Tabs\Tab::make('Hình ảnh')
                                ->icon('heroicon-o-photo')
                                ->schema([
                                    Forms\Components\Section::make('Ảnh thương hiệu')
                                        ->collapsible()
                                        ->schema([
                                            Forms\Components\FileUpload::make('logo')
                                                ->label('Logo')
                                                ->disk('public')
                                                ->directory('uploads/')
                                                ->deleteUploadedFileUsing(fn ($file) => Storage::disk('public')->delete($file))
                                                ->image()
                                                ->imageEditor()
                                                ->imageEditorAspectRatios(['16:9', '4:3', '1:1', '3:4', '9:16'])
                                                ->helperText(fn() => new \Illuminate\Support\HtmlString(
                                                    'Định dạng: <span class="text-primary-600">jpg, jpeg, png, webp, svg</span>'
                                                )),
                                        ]),
                                    Forms\Components\Section::make('Ảnh mặc định')
                                        ->description('Ảnh này sẽ được sử dụng khi không có ảnh chính')
                                        ->collapsible()
                                        ->schema([
                                            Forms\Components\FileUpload::make('tmp_pic')
                                                ->label('Ảnh')
                                                ->disk('public')
                                                ->directory('uploads/')
                                                ->deleteUploadedFileUsing(fn ($file) => Storage::disk('public')->delete($file))
                                                ->image()
                                                ->imageEditor()
                                                ->imageEditorAspectRatios(['16:9', '4:3', '1:1', '3:4', '9:16'])
                                                ->helperText(fn() => new \Illuminate\Support\HtmlString(
                                                    'Định dạng: <span class="text-primary-600">jpg, jpeg, png, webp, svg</span>'
                                                )),
                                        ]),
                                ]),
                                
                            Forms\Components\Tabs\Tab::make('Liên hệ & Mạng xã hội')
                                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                ->schema([
                                    Forms\Components\Section::make('Zalo & Facebook')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('zalo')
                                                ->label('Số Zalo')
                                                ->tel()
                                                ->prefixIcon('heroicon-m-device-phone-mobile'),
                                            Forms\Components\TextInput::make('facebook')
                                                ->label('Facebook')
                                                ->url()
                                                ->prefixIcon('heroicon-m-link'),
                                            Forms\Components\TextInput::make('messenger')
                                                ->label('Messenger')
                                                ->url()
                                                ->prefixIcon('heroicon-m-chat-bubble-left-ellipsis'),
                                        ]),
                                    Forms\Components\Section::make('Google Map')
                                        ->schema([
                                            Forms\Components\Textarea::make('google_map')
                                                ->label('Mã nhúng bản đồ')
                                                ->rows(3)
                                                ->helperText('Dán mã nhúng (iframe) từ Google Maps'),
                                        ]),
                                ]),
                        ])->contained(false),
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
