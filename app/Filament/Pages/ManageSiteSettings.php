<?php

namespace App\Filament\Pages;

use App\Models\SiteSettings;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationGroup = 'Site';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $title = 'Site Settings';

    protected static string $view = 'filament.pages.manage-site-settings';

    public ?SiteSettings $record = null;

    public ?array $data = [];

    public function mount(): void
    {
        $this->record = SiteSettings::first() ?? SiteSettings::create([
            'site_name' => 'Ethos Studio',
            'tagline' => null,
            'footer_email' => null,
            'copyright' => null,
        ]);

        $this->form->fill($this->record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('site_name')
                    ->required(),

                TextInput::make('tagline'),

                TextInput::make('footer_email')
                    ->email(),

                TextInput::make('copyright'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);

        Notification::make()
            ->title('Site settings saved')
            ->success()
            ->send();
    }
}
