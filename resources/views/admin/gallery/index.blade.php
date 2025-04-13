@extends("layouts.overall")
@section("page_title", "Gallery")
@section('module', 'Gallery')
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
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="flaticon2-pen"></i> Create Gallery    
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
                                    {{-- @foreach($galleries as $gallery)
                                        <div class="grid-item col-sm-12 col-md-12 col-lg-6 col-xl-4 watch">
                                            <div class="gallery-box">
                                                <div class="gallery-preview">
                                                    @php
                                                        $img_ext = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

                                                        $file = optional($gallery->images->where('is_preview', 1)->first());

                                                        $file_url = $file->file_url ?? asset('uploads/default-image.jpeg');

                                                        $exts = explode('.', $file_url);
                                                    @endphp

                                                    @if(in_array(strtolower(end($exts)), $img_ext))
                                                        <img src="{{ $file_url }}" class="img-fluid" alt="gallery image" style="width: 200px; height: 150px">
                                                    @else
                                                        <img src="{{ asset('uploads/video-image.jpeg') }}" class="img-fluid" alt="gallery image" style="width: 200px; height: 150px">
                                                    @endif
                                                </div>
                                                <div class="gallery-content">
                                                    <h5><a href="#">{{ $gallery->title }}</a></h5>
                                                    <a href="{{ route('admin.gallery.edit', ['gallery_id' => $gallery->id]) }}" class="btn btn-warning">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach --}}
                                    @foreach($galleries as $gallery)
                                        @php
                                            $img_ext = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

                                            $file = optional($gallery->images->where('is_preview', 1)->first());

                                            $file_url = $file->file_url ?? asset('uploads/default-image.jpeg');

                                            $exts = explode('.', $file_url);
                                        @endphp

                                        <div class="col-lg-4">
                                            <div class="card card-custom overlay">
                                                <div class="card-body p-0">
                                                    <div class="overlay-wrapper">
                                                        @if(in_array(strtolower(end($exts)), $img_ext))
                                                            <img src="{{ $file_url }}" class="w-100 rounded" alt="gallery image" style="height: 200px; object-fit: cover;">
                                                        @else
                                                            <img src="{{ asset('uploads/video-image.jpeg') }}" class="w-100 rounded" alt="gallery image" style="height: 200px; object-fit: cover;">
                                                        @endif
                                                    </div>
                                                    <div class="overlay-layer align-items-end justify-content-center">
                                                        <div class="d-flex flex-grow-1 flex-center bg-white-o-5 py-5">
                                                            <a href="{{ route('admin.gallery.edit', ['gallery_id' => $gallery->id]) }}" class="btn font-weight-bold btn-warning btn-shadow">Edit Gallery</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
