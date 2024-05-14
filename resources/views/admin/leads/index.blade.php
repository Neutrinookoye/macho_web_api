@extends("layouts.overall")
@section("page_title", "Leads/Contacts")
@section('module', 'Enquires')
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
            {{-- <a href="{{ route('admin.leads.export') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                 Export all Leads
            </a> --}}
            <a href="#" class="btn btn-warning font-weight-bolder font-size-sm mr-3" data-toggle="modal" data-target="#export-lead">
                <i class="flaticon2-pen"></i> Export Leads
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
                                        <th>Organization</th>
                                        <th>Brief</th>
                                        {{-- <th>Message</th> --}}
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($leads as $lead)
                                    <tr>
                                        <td>
                                            {{ $cnt++ }}
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $lead->first_name . '' .$lead->last_name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $lead->email }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $lead->organization }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $lead->brief }}
                                                </span>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $lead->message }}
                                                </span>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    @php
                                                        $timestamp = $lead->created_at;
                                                        $carbonDate = \Carbon\Carbon::parse($timestamp);
                                                        $leadDate = $carbonDate->format('d/m/Y');
                                                    @endphp
                                                    {{ $leadDate }}
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

<div class="modal fade" id="export-lead" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"><b>Export Leads/Contacts</b></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-custom">

                    <!--begin::Form-->
                    <form class="form" action="{{ route('admin.leads.export') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="card-body">
                            <div class="text-center pt-4">
                                <div class="row pb-5">
                                    <div class="col-md-6">
                                        <label for="filter_by_distributor" style="white-space: nowrap;">Start Date </label>
                                        <input class="date form-control" type="date" id="filter_by_date" name="start_date" />
                                    </div>
                                        
                                    <div class="col-md-6">
                                        <label for="filter_by_date" style="white-space: nowrap;">End Date </label>
                                        <input class="date form-control" type="date" id="filter_by_date" name="end_date" />
                                    </div>
                                </div>
                                <button data-dismiss="modal" type="button" class="btn btn-light me-3">Close</button>
                                <button type="submit" class="btn btn-warning">
                                    <span class="indicator-label">Export</span>
                                </button>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <div class="text-center pt-4 pb-2">
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Start Date: </label>
                                    <div class="col-9">
                                        <input class="date form-control" type="date" id="start_date" name="start_date" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">End Date: </label>
                                    <div class="col-9">
                                        <input class="date form-control" type="date" id="end_date" name="end_date" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button data-dismiss="modal" type="button" class="btn btn-light me-3">Close</button>
                                        <button type="submit" class="btn btn-warning">
                                            <span class="indicator-label">Export</span>
                                        </button>
                                    </div>
                                </div>
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
