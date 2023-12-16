@if (session('success'))
    <x-alert type="success" :dismissible='true' class="text-center">
        {{ session('success') }}
    </x-alert>
@endif
@if (session('error'))
    <x-alert type="danger" :dismissible='true' class="text-center">
        {{ session('error') }}
    </x-alert>
@endif
