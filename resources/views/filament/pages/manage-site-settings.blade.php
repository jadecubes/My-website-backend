<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div style="margin-top: 16px;">
            <x-filament::button type="submit">
                Save
            </x-filament::button>
        </div>
    </form>

    <iframe
        src="{{ rtrim(config('app.frontend_url'), '/') }}"
        style="width:100%;height:600px;border:1px solid #e5e7eb;border-radius:6px;margin-top:24px;"
    ></iframe>
</x-filament-panels::page>
