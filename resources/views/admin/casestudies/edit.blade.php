@extends("layouts.overall")
@section("page_title", "Edit Case Study")
@section('module', 'Case Studies')
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
            <a href="{{ route('admin.case.studies.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="ki-duotone ki-add-folder"></i> View all Case Studies
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
                            </h3>

                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                
                            </div>
                        </div>

                        <form class="form" action="{{ route('admin.case.studies.edit', $casestudy->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Name <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Case Study Name" value="{{ $casestudy->name }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Caption <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="caption" placeholder="Case Study Caption" value="{{ $casestudy->caption }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label>Project <span class="text-danger"><b>*</b></span></label>
                                        <select id="category" name="project" class="form-control">
                                            <option value="none" selected="" disabled="">Choose a Project</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}" {{$project->id == $casestudy->project_id ? 'selected' : ''}}>{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Service <span class="text-danger"><b>*</b></span></label>
                                        <select id="category" name="service" class="form-control">
                                            <option value="none" selected="" disabled="">Choose a Service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" {{$service->id == $casestudy->service_id ? 'selected' : ''}}>{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Brand <span class="text-danger"><b>*</b></span></label>
                                        <select id="category" name="brand" class="form-control">
                                            <option value="none" selected="" disabled="">Choose a Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{$brand->id == $casestudy->brand_id ? 'selected' : ''}}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Location <span class="text-danger"><b>*</b></span></label>
                                        <select id="category" name="location" class="form-control">
                                            <option value="none" selected="" disabled="">Choose a Location</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" {{$location->id == $casestudy->location_id ? 'selected' : ''}}>{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>About Section </label>
                                        <textarea type="text" id="about" class="form-control" name="about" placeholder="">{{ $casestudy->about }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Brief Section <span class="text-danger"><b>*</b></span></label>
                                        <textarea type="text" id="brief" class="form-control" name="brief" placeholder="">{{ $casestudy->brief }}</textarea>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Challenge Section </label>
                                        <textarea type="text" id="challenge" class="form-control" name="challenge" placeholder="">{{ $casestudy->challenge }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Approach Section <span class="text-danger"><b>*</b></span></label>
                                        <textarea type="text" id="approach" class="form-control" name="approach" placeholder="">{{ $casestudy->approach }}</textarea>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Outcome Section <span class="text-danger"><b>*</b></span></label>
                                        <textarea type="text" id="outcome" class="form-control" name="outcome" placeholder="">{{ $casestudy->outcome }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row pt-3">
                                    <div class="col-lg-6">
                                        <label>First Background Image <span class="text-danger"><b>*</b></span></span> <span class="font-weight-bolder"></span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="first_background_image" accept="image/png,image/jpeg,image/jpg" value="{{ old('first_background_image') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Second Background Image <span class="text-danger"><b>*</b></span></span> <span class="font-weight-bolder"></span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="second_background_image" accept="image/png,image/jpeg,image/jpg" value="{{ old('second_background_image') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row pt-3">
                                    <div class="col-lg-6">
                                        <label>Logo <span class="text-danger"><b>*</b></span></span> <span class="font-weight-bolder"></span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="logo" accept="image/png,image/jpeg,image/jpg" value="{{ old('logo') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Case Study Document <span class="text-danger"><b>*</b></span></span> <span class="font-weight-bolder"></span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="document" accept=".pdf,.doc,.docx,.txt" value="{{ old('document') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-4">
                                    <div class="d-flex flex-stack">
       
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" @if($casestudy->status == 1) checked="checked" @endif name="status" />
                                            <span class="form-check-label fw-semibold text-muted mr-4">Status</span>
                                        </label>

                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" @if($casestudy->is_featured == 1) checked="checked" @endif name="is_featured" />
                                            <span class="form-check-label fw-semibold text-muted">Featured</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>

                                    <div class="d-flex flex-stack md-6 mt-4">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <a href="{{ route('admin.project.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                                <!-- begin: Example Code-->
                                <!-- end: Example Code-->
                            </div>
                        </form>

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

@push('js')
<script>
    $('#brief').summernote({
      placeholder: 'Case study brief...',
      tabsize: 2,
      height: 200,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen']]
      ]
    });

    var input1 = document.querySelector("#kt_tagify_1");
    new Tagify(input1);
</script>

<script>
    $('#about').summernote({
      placeholder: 'About Case study...',
      tabsize: 2,
      height: 200,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen']]
      ]
    });

    var input1 = document.querySelector("#kt_tagify_1");
    new Tagify(input1);
</script>

<script>
    $('#challenge').summernote({
      placeholder: 'Case study challenges...',
      tabsize: 2,
      height: 200,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen']]
      ]
    });

    var input1 = document.querySelector("#kt_tagify_1");
    new Tagify(input1);
</script>

<script>
    $('#approach').summernote({
      placeholder: 'Case study approach...',
      tabsize: 2,
      height: 200,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen']]
      ]
    });

    var input1 = document.querySelector("#kt_tagify_1");
    new Tagify(input1);
</script>

<script>
    $('#outcome').summernote({
      placeholder: 'Case study outcome...',
      tabsize: 2,
      height: 200,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen']]
      ]
    });

    var input1 = document.querySelector("#kt_tagify_1");
    new Tagify(input1);
</script>
    
@endpush

@endsection