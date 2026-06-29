<div class="d-flex flex-column sidebar pt-4">
    <a href="{{ route('home') }}"><i class="fa-solid fa-house me-3"></i>Home</a>
    @can('admin')
        <a href="#"><i class="fas fa-users me-3"></i>Colaborators</a>
        <a href="#"><i class="fa-solid fa-user-gear me-3"></i>RH Colaborators</a>
        <a href="{{ route('departments') }}"><i class="fa-solid fa-industry me-3"></i>Departament</a>

    @endcan
    <hr>



    <a href="{{ route('user.profile')}}"><i class="fa-solid fa-cog me-3"></i>User profile</a>
    <hr>
     
    {{-- logout --}}
    <div class="text-center mt-3">
        <form action="{{route('logout')}}" method="post">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-dark">
                <i class="fas fa-sign-out-alt me-3"></i>Logout
            </button>
        </form>
    </div>

</div>