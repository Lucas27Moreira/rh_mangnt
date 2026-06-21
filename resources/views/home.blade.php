<x-layout-app pageTitle="Home">
    <h1 class="text-center">DENTRO DO HOME</h1>

    @php 
    dump(auth()->user());
    @endphp
</x-layout-app>