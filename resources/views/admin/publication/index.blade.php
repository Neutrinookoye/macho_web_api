@extends("layouts.overall")
@section("page_title", "All Publications")
@section('module', 'Publications')
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
            <a href="{{ route('admin.publication.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="flaticon2-pen"></i> Create Publications
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
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Publication Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cnt = 1;
                                    @endphp
                                    @foreach($publications as $publication)
                                    <tr>
                                        <td>
                                            {{ $cnt++ }}
                                        </td>
                                        <td>
                                            <img src="{{ asset('uploads/publications') }}/{{ $publication->thumb_image }}" style="width: 75px; height: 50px" alt="Icon">
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ $publication->title }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $publication->category_name }}
                                        </td>
                                        <td>
                                            <div>
                                                @if ($publication->status == 1)
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Active</span>
                                                @endif
                                                @if ($publication->status == 0)
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Inactive</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{ date('d/m/Y', strtotime($publication->publication_date)) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.publication.edit', $publication->id) }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                                <i class="flaticon2-edit"></i> 
                                            </a>
                                            <a href="{{ asset('uploads/publications/' . $publication->publication_file) }}" target="blank" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                                <i class="flaticon-download"></i> 
                                            </a>
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

@endsection
