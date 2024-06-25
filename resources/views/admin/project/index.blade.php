@extends("layouts.overall")
@section("page_title", "Projects")
@section('module', 'Projects')
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
            <a href="{{ route('admin.project.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="flaticon2-pen"></i> Create Project    
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
                            </h3>
                        </div>

                        <div class="card-body p-lg-20">
                            <!--begin::Section-->
                            <div class="mb-17"> 
                                <div class="row g-10">
                                    <!--begin::Col-->
                                    @foreach($projects as $project)
                                    <div class="col-md-4 mb-5">
                                        <div class="card-xl-stretch me-md-6">
                                            <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                                href="{{ $project->thumb_image }}" target="_blank">
                                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                    style="background-image:url('{{ $project->thumb_image }}')">
                                                </div>
                                            </a>

                                            <div class="mt-3">
                                                <p href="{{ route('admin.project.edit', $project->id) }}"
                                                    class="text-dark-75 font-weight-bolder font-size-lg" style="font-size: 1.2rem;">
                                                    <b>{{ Str::limit(($project->name), '35')}}</b>
                                                </p>                                                

                                                <div class="fs-6 fw-bold d-flex flex-stack">
                                                    <small>
                                                        @if ($project->status == 1)
                                                        <span class="text-white-100 font-weight-bolder font-size-sm mr-2 badge bg-success">Active</span>
                                                        @endif
                                                        @if ($project->is_featured == 1)
                                                        <span class="text-white-100 font-weight-bolder font-size-sm mr-2 badge bg-primary">Featured</span>
                                                        @endif
                                                        @if ($project->status == 0)
                                                        <span class="text-white-100 font-weight-bolder font-size-sm mr-2 badge bg-danger">Inactive</span>
                                                        @endif
                                                        @if ($project->is_featured == 0)
                                                        <span class="text-white-100 font-weight-bolder font-size-sm mr-2 badge bg-secondary">Not Featured</span>
                                                        @endif
                                                    </small>
                                                </div>

                                                {{-- <div class="fs-6 d-flex flex-stack">
                                                    <small>
                                                        @if ($project->is_featured == 1)
                                                        <span class="text-dark-75 font-weight-bold d-block font-size-lg">Featured</span>
                                                        @endif
                                                        @if ($project->is_featured == 0)
                                                        <span class="text-dark-75 font-weight-bold d-block font-size-lg">Not Featured</span>
                                                        @endif
                                                    </small>
                                                </div> --}}

                                                <div class="fs-6 mt-1 d-flex flex-stack">
                                                    <p>
                                                        Created on {{ date('d M, Y', strtotime($project->created_at)) }} by {{ $project->created_by_name }}
                                                    </p>
                                                </div>

                                                <div class="fs-6 fw-bold mt-2 d-flex flex-stack">
                                                    
                                                        <a href="{{ route('admin.project.edit', $project->id) }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                                                            <i class="flaticon2-edit"></i> Edit
                                                        </a>
                                                </div>
                                                
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Hot sales post-->
                                        <br>
                                    </div>
                                    
                                    @endforeach
                                   
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Section-->

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
