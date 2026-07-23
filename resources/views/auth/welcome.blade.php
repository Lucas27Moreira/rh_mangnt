<x-layout-guest pageTitle="Welcome">
    <div class="row justify-content-center">
        <div class="col">
            {{-- logo --}}
            <div class="text-center mb-5">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="200px">
            </div>
            {{-- welcome message --}}
            <div class="card p-5 text-center">
                <h1 class="text-center mb-4">Welcome {{$user->name}}</h1>
                <p class="text-center">You have successfully registered!</p>
                <p class="text-center">You can now <a href="{{ route('login') }}">login</a> to your account.</p>
            </div>
        </div>
    </div>
</x-layout-guest>