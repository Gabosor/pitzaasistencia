<x-filament::page>
    {{ $this->form }}
    <x-filament::button wire:click="generatePdf" class="mt-4">
        Generar Planilla
    </x-filament::button>
</x-filament::page>
