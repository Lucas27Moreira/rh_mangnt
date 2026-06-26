<x-layout-app page-title="User Profile">
    <div class="w-100 p-4">
        <h3>User Profile</h3>
        <hr>
        <div class="d-flex flex-wrap align-items-center gap-4 border-bottom pb-3 mb-3">
            <div class="d-flex align-items-center text-muted">
                <i class="fa-solid fa-user me-2"></i>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <div class="d-flex align-items-center text-muted">
                <i class="fa-solid fa-user-tag me-2"></i>
                <span>{{ auth()->user()->role }}</span>
            </div>
            <div class="d-flex align-items-center text-muted">
                <i class="fa-solid fa-at me-2"></i>
                <span>{{ auth()->user()->email }}</span>
            </div>
            <div class="d-flex align-items-center text-muted">
                <i class="fa-solid fa-calendar-days me-2"></i>
                <span>{{ auth()->user()->created_at->format('d/m/y') }}</span>
            </div>
        </div>
    </div>
</x-layout-app>