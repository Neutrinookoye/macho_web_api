@extends("layouts.overall")
@section("page_title", "Roles")
@section('module', 'System')
@section("content")

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    @include('admin.includes.bodytop')
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
                        $permissions = fetchPermissions($status);
                    @endphp
                <div class="col-xxl-12 col-md-12 order-2 order-xxl-1">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">List of @yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                                @php
                                    $roles = fetchRoles();
                                @endphp
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                @if(checkPermission('add_role'))
                                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#addCustomer">
                                        <i class="ki-duotone ki-add-folder"></i> Create Role
                                    </a>
                                @endif
                            </div>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table class="table align-middle gs-0 gy-4" id="example" style="width:100%">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold text-white bg-warning">
                                        <th>Name</th>
                                        {{-- <th class="min-w-125px">Slug</th> --}}
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                               
                                                <div class="d-flex justify-content-start flex-column">
                                                    <a href="#" style="text-decoration: none;" class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{ $role->name }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">{{ $role->slug }}</a>
                                        </td> --}}
                                        <td>
                                            @if($role->status == 1)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Active</span>
                                            @endif
                                            @if($role->status == 0)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(checkPermission('edit_role'))
                                            <button href="#" class="btn btn-icon btn-warning" data-toggle="modal" data-target="#edit-customer{{ $role->id }}">
                                                <i class="flaticon-edit"></i>
                                            </button>
                                            @endif
                                            
                                            <div class="modal fade" id="edit-customer{{ $role->id }}" tabindex="-1" aria-hidden="true">
                                                <!--begin::Modal dialog-->
                                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                    <!--begin::Modal content-->
                                                    <div class="modal-content">
                                                        <!--begin::Modal header-->
                                                        <div class="modal-header">
                                                            <!--begin::Modal title-->
                                                            <h2>Edit Role</h2>
                                                            <!--end::Modal title-->
                                                            <!--begin::Close-->
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                            <!--end::Close-->
                                                        </div>
                                                        <!--end::Modal header-->
                                                        <!--begin::Modal body-->
                                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                            <!--begin::Form-->
                                                            <form class="form" action="{{ route('admin.roles.edit', ['role_id' => $role->id]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-2">
                                                                        <!--begin::Input group-->
                                                                        <div class="d-flex flex-column mb-7 fv-row">
                                                                            <!--begin::Label-->
                                                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                                                <span class="required">Name</span>
                                                                                
                                                                            </label>
                                                                            <!--end::Label-->
                                                                            <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{ $role->name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--end::Input group-->

                                                               
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-2">
                                                                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                                            <span class="required">Permissions</span>
                                                                            
                                                                        </label>
                                                                    </div>
                                                                    @php
                                                                        $role_permissions = $role->rolePermissions->pluck('permission_id')->toArray();
                                                                    @endphp
                                                                @foreach ($permissions as $permission)
                                                                <div class="col-md-4 mb-2">
                                                                    <div class="d-flex flex-stack custom_switch">
                                                                    
                                                                        <!--begin::Switch-->
                                                                        
                                                                        <label class="form-check switch form-check-custom">
                                                                            <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" name="permissions[]" @if(in_array($permission->id, $role_permissions)) checked @endif>
                                                                            <span class="form-check-label fw-semibold text-muted">{{ $permission->name }}</span>
                                                                        </label>
                                                                        <!--end::Switch-->
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                </div>
                                                               <hr>
                                                                <!--begin::Input group-->
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-2">
                                                                        <div class="d-flex flex-stack custom_switch">
                                                                        
                                                                            <!--begin::Switch-->
                                                                            <label class="form-check switch form-check-custom">
                                                                                <input class="form-check-input" type="checkbox" value="1" @if($role->status == 1) checked @endif name="status" />
                                                                                <span class="form-check-label fw-semibold text-muted">Active</span>
                                                                            </label>
                                                                            <!--end::Switch-->
                                                                        </div>
                                                                    </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                    <div class="col-md-12 mb-2">
                                                                        <div class="text-center pt-15">
                                                                            <button data-dismiss="modal" type="button" class="btn btn-light me-3">Discard</button>
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <span class="indicator-label">Save</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </form>
                                                            <!--end::Form-->
                                                        </div>
                                                        <!--end::Modal body-->
                                                    </div>
                                                    <!--end::Modal content-->
                                                </div>
                                                <!--end::Modal dialog-->
                                            </div>

                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            {{-- {{ $customer->render() }} --}}
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

<div class="modal fade" id="addCustomer" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-custom">

                    <!--begin::Form-->
                    <form action="{{ route('admin.roles.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                            <span class="required">Name</span>
                                            
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid" placeholder="" name="name" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                        <span class="required">Permissions</span>
                                        
                                    </label>
                                </div>
                            @foreach ($permissions as $permission)
                            <div class="col-md-4 mb-2">
                                <div class="d-flex flex-stack custom_switch">
                                
                                    <!--begin::Switch-->
                                    
                                    <label class="form-check switch form-check-custom">
                                        <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" name="permissions[]" />
                                        <span class="form-check-label fw-semibold text-muted">{{ $permission->name }}</span>
                                    </label>
                                    <!--end::Switch-->
                                </div>
                            </div>
                            @endforeach
                            </div>
                            <hr>
                            <!--end::Input group-->
                           
                            <!--begin::Input group-->
                            <div class="d-flex flex-stack custom_switch">
                               
                                <!--begin::Switch-->
                                <label class="form-check switch form-check-custom">
                                    <input class="form-check-input" type="checkbox" value="1" checked="checked" name="status" />
                                    <span class="form-check-label fw-semibold text-muted">Active</span>
                                </label>
                                <!--end::Switch-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center pt-15">
                                <button data-dismiss="modal" type="button" class="btn btn-light me-3">Discard</button>
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

@endsection