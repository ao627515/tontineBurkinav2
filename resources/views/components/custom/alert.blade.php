@if (session('success'))
    <x-alert type="success" :dismissible='true'>
        {{ session('success') }}
    </x-alert>
@endif
@if (session('error'))
    <x-alert type="danger" :dismissible='true'>
        {{ session('error') }}
    </x-alert>
@endif
