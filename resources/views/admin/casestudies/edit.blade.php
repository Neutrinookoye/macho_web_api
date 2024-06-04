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
                                    <div class="col-lg-4">
                                        <label>Caption <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" maxlength="40" name="caption" placeholder="Case Study Caption" value="{{ $casestudy->caption }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Project Year <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="year" placeholder="" value="{{ $casestudy->year }}" />
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
                                        <label>Short Description <span class="text-danger"><b>*</b></span> <small class="muted">(200 characters max)</small></label>
                                        <textarea rows="3" type="text" maxlength="200" class="form-control" name="short_description" placeholder="">{{ $casestudy->short_description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>About Section <span class="text-danger"><b>*</b></span></label>
                                        <textarea type="text" id="about" class="form-control" name="about" placeholder="">{{ $casestudy->about }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Brief Section <span class="text-danger"><b>*</b></span></label>
                                        <textarea type="text" id="brief" class="form-control" name="brief" placeholder="">{{ $casestudy->brief }}</textarea>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Challenge Section <span class="text-danger"><b>*</b></span></label>
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
                                        <label>Banner Image <span class="text-danger"><b>*</b></span></span> <small>(1440px x 580px)</small> <span class="font-weight-bolder"></span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="first_background_image" accept="image/png,image/jpeg,image/jpg" value="{{ old('first_background_image') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Video Image <span class="text-danger"><b>*</b></span></span> <small>(1279px x 628px)</small> <span class="font-weight-bolder"></span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="second_background_image" accept="image/png,image/jpeg,image/jpg" value="{{ old('second_background_image') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pt-3">
                                    <div class="col-lg-6">
                                        <label>Video URL <span class="font-weight-bolder"></span></label>
                                        <div class="input-group">
                                        <input type="text" class="form-control form-control-solid" placeholder="Video Url" name="video_url" value="{{ $casestudy->video_url }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Case Study Document <span class="text-danger"><b>*</b></span></span> <span class="font-weight-bolder"></span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control form-control-solid" placeholder="" name="document" accept=".pdf,.doc,.docx,.txt" value="{{ old('document') }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group row pt-3">
                                    
                                </div> --}}

                                <div class="row">
                                    <div class="col-md-12 mb-2 mt-5 cntinputs add-more-inputs1">
                                        <div class="d-flex flex-column mb-7 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Case study Images </span>&emsp;&emsp;
                                                <button class="btn btn-warning font-weight-bolder font-size-sm mr-3" onclick="addMore(event)">Add more images 
                                                    <i class="flaticon2-plus"></i>
                                                </button>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="add-more-div">
                                    <div class="col-md-12 mb-2 mt-5 cntinputs add-more-inputs1">
                                        <div class="d-flex flex-column mb-7 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Image 1 <small>(627px x 417px)</small> </span>&emsp;&emsp;
                                            </label>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="file" class="form-control form-control-solid" placeholder="" name="images[]"
                                                        accept="image/png,image/gif,image/jpeg,image/jpg">
                                                </div>
                                                <div class="col-md-2">
                                                    {{-- <span class="btn btn-danger" onclick="removeInput('add-more-inputs${cnt}')" style="cursor: pointer"><span class="feather icon-trash-2"></span></span> --}}
                                                </div>
                                            </div>
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

            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3">Case study Images</span>
                        {{-- <span class="text-muted mt-1 fw-semibold fs-7">Over 500 new products</span> --}}
                       
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body px-lg-20">

                    <!--begin::Section-->
                    <div class="mb-5">
                        <!--begin::Content-->
                        <!--begin::Row-->
                        <div class="row g-10">
                            <!--begin::Col-->
                            @foreach($casestudy->images as $image)
                            <div class="col-md-4">
                                <!--begin::Hot sales post-->
                                <div class="card-xl-stretch me-md-6">
                                    <!--begin::Overlay-->
                                    <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                        href="{{ $image->image }}" target="_blank">
                                        <!--begin::Image-->
                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                            style="background-image:url('{{ $image->image }}')">
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Action-->
                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                            <i class="ki-duotone ki-eye fs-2x text-white">
                                            </i>
                                        </div>
                                        <!--end::Action-->
                                    </a>
                                    <!--end::Overlay-->
                                    <!--begin::Body-->
                                    <div class="mt-5">
                                        <div class="fs-6 fw-bold mt-5 d-flex flex-stack text-center">
                                            {{-- <button onclick="alertDelete('{{ $project->id }}', '{{ $image->id }}')" class="btn btn-sm btn-danger"> --}}
                                            <button onclick="alertDelete({{ $image->id }})" class="btn btn-sm btn-danger">
                                                <i class="flaticon2-rubbish-bin">
                                                </i> Remove</button>
                                            <!--end::Action-->
                                        </div>
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

                    <div class="">
                        <!--begin::Content-->
                        <!--begin::Row-->
                        <div class="row g-10">
                            <!--begin::Col-->
                            
                            <div class="col-md-4 mb-5">
                                <!--begin::Hot sales post-->
                                <div class="card-xl-stretch me-md-6">
                                    <!--begin::Overlay-->
                                    <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                        href="{{ $casestudy->page_bg }}" target="_blank">
                                        <!--begin::Image-->
                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                            style="background-image:url('{{ $casestudy->page_bg }}')">
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Action-->
                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                            <i class="ki-duotone ki-eye fs-2x text-white">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                        <!--end::Action-->
                                    </a>
                                    <!--end::Overlay-->
                                    <!--begin::Body-->
                                    <div class="mt-5">
                                        <div class="fs-6 fw-bold mt-5 d-flex flex-stack text-center">
                                            <span
                                                class="badge border border-dashed fs-2 fw-bold text-dark p-2">
                                               Banner Image</span>
                                            
                                            <!--end::Action-->
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Hot sales post-->
                                <br>
                            </div> 
                            
                            <div class="col-md-4 mb-5">
                                <!--begin::Hot sales post-->
                                <div class="card-xl-stretch me-md-6">
                                    <!--begin::Overlay-->
                                    <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                        href="{{ $casestudy->page_bg2 }}" target="_blank">
                                        <!--begin::Image-->
                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                            style="background-image:url('{{ $casestudy->page_bg2 }}')">
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Action-->
                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                            <i class="ki-duotone ki-eye fs-2x text-white">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                        <!--end::Action-->
                                    </a>
                                    <!--end::Overlay-->
                                    <!--begin::Body-->
                                    <div class="mt-5">
                                        <div class="fs-6 fw-bold mt-5 d-flex flex-stack text-center">
                                            <span
                                                class="badge border border-dashed fs-2 fw-bold text-dark p-2">
                                               Video Image</span>
                                            
                                            <!--end::Action-->
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Hot sales post-->
                                <br>
                            </div> 
                        </div>
                        <!--end::Row-->
                    </div>
                </div>
                <!--begin::Body-->
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

<script>
        var cnt = 1;
    function addMore(e)
    {
        cnt += 1;
        e.preventDefault()

        if($(".cntinputs").length >= 11)
        {
            Swal.fire({
                title: 'Cancelled',
                text: "Sorry! You cannot add more than 10 images",
                width: '400px',
                customClass: {
                    confirmButton: "btn btn-danger"
                }
            })
            return
        }

        $("#add-more-div").prepend(`
            <div class="col-md-12 mb-2 mt-5 cntinputs add-more-inputs${cnt}">
                <div class="d-flex flex-column mb-7 fv-row">
                    <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                        <span class="required"> Image ${cnt} <small>(627px x 417px)</small></span>
                    </label>
                    <div class="row">
                        <div class="col-md-10">
                            <input type="file" class="form-control form-control-solid" placeholder="" name="images[]"
                                accept="image/png,image/gif,image/jpeg,image/jpg">
                        </div>
                        <div class="col-md-2">
                            <span class="btn btn-danger" onclick="removeInput('add-more-inputs${cnt}')" style="cursor: pointer">
                                <i class="flaticon2-rubbish-bin"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        `)
    }


    function removeInput(elem)
    {
        $(`#add-more-div .${elem}`).remove()
    }

    function alertDelete(id)
    {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-primary"
            }
        }).then(function(result) {
            if (result.value) {
                Swal.fire(
                    "Deleted!",
                    "Your file has been deleted.",
                    "success"
                )
                // window.location.href = "{{ route('admin.project.remove.image', ['project_id' => ':project_id', 'image_id' => ':image_id']) }}".replace(':project_id', project_id).replace(':image_id', image_id);
                window.location.href = "{{ url('admin/case-studies/remove-casestudy-image') }}/{{ $casestudy->id }}/"+id;
            } else if (result.dismiss === "cancel") {
                Swal.fire(
                    "Cancelled",
                    "Your action has been aborted :)",
                    "error"
                )
            }
        });
    }
</script>
    
@endpush

@endsection