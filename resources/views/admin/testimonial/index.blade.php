@extends("layouts.overall")
@section("page_title", "Testimonials")
@section('module', 'Team')
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
                    {{-- <li class="breadcrumb-item">
                        <a href="" class="text-muted">@yield('module')</a>
                    </li> --}}
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a>
                    </li>

                </ul>
            </div>
            <a href="#" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#create-category">
                <i class="flaticon2-pen"></i> Create Testimonial
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
                <div class="col-xxl-12 col-md-12 order-2 order-xxl-1">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">List of @yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>
                            <div class="card-toolbar">

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
                                        <th>Designation</th>
                                        <th>Company</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($testimonials as $testimonial)
                                        <tr>
                                            <td>
                                                {{ $cnt++ }}
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                        {{ $testimonial->name}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                        {{ $testimonial->designation}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                        {{ $testimonial->company}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                        {{ $testimonial->message}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($testimonial->status == 1)
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Active</span>
                                                @endif
                                                @if ($testimonial->status == 0)
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button href="#" class="btn btn-icon btn-warning" data-toggle="modal" data-target="#edit-category{{ $testimonial->id }}">
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
@foreach($testimonials as $testimonial)
    <div class="modal fade" id="edit-category{{ $testimonial->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Team Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">

                        <!--begin::Form-->
                        <form action="{{ route('admin.testimonial.edit', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ $testimonial->name }}" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Designation <span class="text-danger">*</span></label>
                                            <input type="text" name="designation" class="form-control" value="{{ $testimonial->designation }}" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Company <span class="text-danger">*</span></label>
                                            <input type="text" name="company" class="form-control" value="{{ $testimonial->company }}" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Message </label>
                                            <textarea rows="5" name="message" class="form-control">{{ $testimonial->message }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Image </label>
                                            <div class="input-group">
                                                <input type="file" class="form-control form-control-solid" placeholder="" name="image" accept=".png, .jpg, .jpeg .gif" value="{{ $testimonial->image }}">
                                            </div>
                                        </div>
                                    </div>
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
                                                    @if ($testimonial->status == 1) checked @endif
                                                    name="status" />
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

<div class="modal fade" id="create-category" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"><b>Create Testimonial</b></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-custom">

                    <!--begin::Form-->
                    <form class="form" action="{{ route('admin.testimonial.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <input type="text" name="designation" class="form-control" value="{{ old('designation') }}" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Company <span class="text-danger">*</span></label>
                                        <input type="text" name="company" class="form-control" value="{{ old('company') }}" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Message </label>
                                        <textarea rows="5" name="message" class="form-control">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Image </label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="image" accept=".png, .jpg, .jpeg .gif" value="{{ old('image') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="d-flex flex-stack mt-5">
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" checked
                                                name="status" />
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


@endsection