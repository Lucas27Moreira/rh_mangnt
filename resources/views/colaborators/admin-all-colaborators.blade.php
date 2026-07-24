<x-layout-app page-title="Colaborators">

    <div class="w-100 p-4">

        <h3>All colaborators</h3>

        <hr>

        <!-- table -->
           @if($colaborators->count() === 0)

         <div class="text-center my-5">
            <p>No collaborators found.</p>
        </div>
        @else
        <table class="table" id="table">
            <thead class="table-dark">
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Department</th>
                <th>Role</th>
                <th>Admission Date</th>
                <th>Salary</th>
                <th></th>
            </thead>
            <tbody>

                @foreach ($colaborators as $colaborator)
                @php
                    $permissions = json_decode($colaborator->permissions); 
                @endphp
                <tr>
                    <td>{{$colaborator->name}}</td>
                    <td>{{$colaborator->email}}</td>
                    <td>
                        @empty($colaborator->email_verified_at)
                           <span class="badge bg-danger">Inactive</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                    <td>{{$colaborator->department->name}}</td>
                    <td>{{$colaborator->role}}</td>
                    <td>{{$colaborator->userDetail->admission_date}}</td>
                    <td>{{$colaborator->userDetail->salary}} $</td>
                    <td>
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="#" class="btn btn-sm btn-outline-darkm ms-3"> <i class="fas fa-eye me-2"></i>Details</a>
                            <a href="#" class="btn btn-sm btn-outline-darkm ms-3"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

</x-layout-app>
