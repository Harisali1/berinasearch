<html lang="en">
<x-head>
    {{ $style ?? '' }}
</x-head>
<body class="homepage-6 homepage-9 homepage-4 hp-6">
<div id="wrapper">
    <x-header></x-header>
    {{ $slot }}
    <x-footer></x-footer>
    <x-scripts>
        {{ $script ?? '' }}
    </x-scripts>
</div>
</body>
</html>
