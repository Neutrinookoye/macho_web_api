@extends("layouts.overall")
@section("page_title", "Admins")
@section('module', 'Users')
@section("content")

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    {{-- @include('admin.includes.bodytop') --}}
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">@yield('page_title')</h5>
                <!--end::Page Title-->
                <!--begin::Actions-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">@yield('module')</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a>
                    </li>

                </ul>
            </div>
            <a href="#" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#add-admin">
                <i class="flaticon2-pen"></i> Create Admin
            </a>
        </div>
        
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row">
                @php
                    $status = 1;
                    $roles = fetchRoles($status);
                @endphp
                <div class="col-xxl-12 col-md-12 order-2 order-xxl-1">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">List of @yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>
                            @php
                                $roles = fetchRoles();
                            @endphp
                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                {{-- <a href="#" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#add-admin">
                                    <i class="flaticon2-add-1"></i> Create Admin
                                </a> --}}

                            </div>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table class="table table-separate table-head-custom table-checkable" id="example" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($admins as $admin)
                                        <tr>
                                            <td>
                                                {{ $cnt++ }}
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                        {{ $admin->name}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                        {{ $admin->email }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($admin->active == 1)
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Active</span>
                                                @endif
                                                @if ($admin->active == 0)
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button href="#" class="btn btn-icon btn-warning" data-toggle="modal" data-target="#edit-admin{{ $admin->id }}">
                                                    <i class="flaticon2-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $admin->render() }} --}}
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 2-->
                </div>

            </div>
            <!--end::Row-->
            <!--end::Dashboard-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->
<!--begin::Footer-->
@foreach($admins as $admin)
    <div class="modal fade" id="edit-admin{{ $admin->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">

                        <!--begin::Form-->
                        <form action="{{ route('admin.admins.edit', $admin->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input name="target" value="{{ $admin->id }}" type="hidden" readonly>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ $admin->name }}" class="form-control alphabetic-input" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                        <span class="required">Password</span>
        
                                    </label>
                                    <!--end::Label-->
                                    <input type="password" class="form-control form-control-solid" placeholder="This is optional" name="password">
                                </div>

                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                <span class="required">Roles</span>

                                </label>
                                <div class="row">
                                    @php
                                        $user_roles = fetchUserRoles($admin->id)
                                            ->pluck('role_id')
                                            ->toArray();
                                    @endphp
                                    @foreach ($roles as $role)
                                        <div class="col-md-4">
                                            <div
                                                class="d-flex flex-stack">

                                                <!--begin::Switch-->

                                                <label
                                                    class="form-check form-check-custom form-check-solid">
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        value="{{ $role->id }}"
                                                        name="role"
                                                        @if (in_array($role->id, $user_roles)) checked @endif>
                                                    <span
                                                        class="form-check-label fw-semibold text-muted">{{ $role->name }}</span>
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex flex-stack mt-5">
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    value="1"
                                                    @if ($admin->active == 1) checked @endif
                                                    name="active" />
                                                <span class="form-check-label fw-semibold text-muted">Active</span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center pt-15">
                                    <button data-dismiss="modal" type="button" class="btn btn-light me-3">Close</button>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Save</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>


                </div>

            </div>
        </div>
    </div>

@endforeach

<div class="modal fade" id="add-admin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"><b>Create New Admin</b></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-custom">

                    <!--begin::Form-->
                    <form class="form" action="{{ route('admin.admins.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <input name="target" value="{{ $admin->id }}" type="hidden" readonly>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control alphabetic-input" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Admin Email<span class="text-danger">*</span></label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required="required">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column mb-7 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Password</span>
    
                                </label>
                                <!--end::Label-->
                                <input type="password" class="form-control form-control-solid" value="{{ old('password') }}" name="password" required="required">
                            </div>

                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                            <span class="required">Roles</span>

                            </label>
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex flex-stack">
    
                                            <!--begin::Switch-->
    
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="{{ $role->id }}"
                                                    name="role" required>
                                                <span
                                                    class="form-check-label fw-semibold text-muted">{{ $role->name }}</span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="d-flex flex-stack mt-5">
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" checked
                                                name="active" />
                                            <span class="form-check-label fw-semibold text-muted">Active</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pt-15">
                                <button data-dismiss="modal" type="button" class="btn btn-light me-3">Close</button>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
                                </button>
                            </div>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>


            </div>

        </div>
    </div>
</div>

@push('js')
<script>
    var numericInputs = document.querySelectorAll('.numeric-input');

    numericInputs.forEach(function(input) {
        input.addEventListener('input', function(event) {
            var inputValue = event.target.value;

            if (/[^0-9]/.test(inputValue)) {
                event.target.value = inputValue.replace(/[^0-9]/g, '');
            }
        });
    });
</script>

<script>
    function allowAlphabets(inputElement) {
        inputElement.addEventListener('input', function(event) {
            var inputValue = event.target.value;

            if (/[^a-zA-Z\s]/.test(inputValue)) {
                event.target.value = inputValue.replace(/[^a-zA-Z\s]/g, '');
            }
        });
    }

    // Usage example
    var alphabeticInputs = document.querySelectorAll('.alphabetic-input');

    alphabeticInputs.forEach(function(input) {
        allowAlphabets(input);
    });
</script>
@endpush


@endsection