@extends("layouts.overall")
@section("page_title", "Job Applications")
@section('module', 'Careers')
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
            <a href="{{ route('admin.career.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                 View all openings
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
                                <span class="card-label font-weight-bolder text-dark">@yield('page_title')</span>
                                {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ $count_target_data }} {{ $count_target_data > 1 ? 'targets' : 'target' }}</span> --}}
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example" class="table table-separate table-head-custom table-checkable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>CV</th>
                                        <th>Cover Letter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>
                                            {{ $cnt++ }}
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $application->last_name }} {{ $application->first_name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $application->email }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $application->phone }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    <a href="{{ asset('uploads/cvs') }}/{{ $application->cv }}" class="btn font-weight-bolder btn-sm btn-warning mr-2" target="_blank">View</a>
                                                    {{-- {{ $application->name }} --}}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{-- <a href="{{ asset('uploads/cover_letter') }}/{{ $application->cover_letter }}" class="btn font-weight-bolder btn-sm btn-primary mr-2" target="_blank">View</a> --}}
                                                    <a href="#" class="btn font-weight-bolder btn-sm btn-warning mr-2" data-toggle="modal" data-target="#add-admin{{ $application->id }}">
                                                        View 
                                                    </a>
                                                    {{-- {{ $application->name }} --}}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
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

@foreach ($applications as $application)
<div class="modal fade" id="add-admin{{ $application->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"><b>Cover Letter</b></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                {{-- <div class="card card-custom"> --}}

                    <div>

                    </div>
                    <!--begin::Form-->
                        {{ $application->cover_letter }}
                    
                    <!--end::Form-->
                {{-- </div> --}}


            </div>

        </div>
    </div>
</div>
@endforeach


@endsection
