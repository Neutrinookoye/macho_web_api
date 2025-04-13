@extends("layouts.overall")
@section("page_title", "Edit Gallery")
@section('module', 'Galleries')
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
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="ki-duotone ki-add-folder"></i> View all Galleries
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

                        <form class="form" action="{{ route('admin.gallery.edit', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-8">
                                        <label>Title <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="form-control" name="title" placeholder="" value="{{ $gallery->title }}" />
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Category <span class="text-danger"><b>*</b></span></label>
                                        <select id="category" name="category" class="form-control">
                                            <option value="none" selected="" disabled="">Choose a Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{$category->id == $gallery->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label> Description <span class="text-danger"><b>*</b></span></label>
                                        <textarea rows="6" type="text" id="description" class="form-control" name="description" placeholder="">{{ $gallery->description }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-2 mt-5 cntinputs add-more-inputs1">
                                        <div class="d-flex flex-column mb-7 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Gallery Images </span>&emsp;&emsp;
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
                                                <span class="required">Image 1 <small>(627px x 417px)</small></span>&emsp;&emsp;
                                            </label>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="file" class="form-control form-control-solid" placeholder="" name="gallery_images[]"
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
                                            <input class="form-check-input" type="checkbox" value="1" checked="checked" name="status" />
                                            <span class="form-check-label fw-semibold text-muted mr-8">Status</span>
                                        </label>
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="is_featured" />
                                            <span class="form-check-label fw-semibold text-muted">Featured</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>

                                    <div class="d-flex flex-stack md-6 mt-4">
                                        <button type="submit" class="btn btn-primary mr-4">Save</button>
                                        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">Cancel</a>
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
                        <span class="card-label fw-bold fs-3">Gallery Images</span>
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
                            @foreach($gallery->images as $image)
                            <div class="col-md-4">
                                <!--begin::Hot sales post-->
                                <div class="card-xl-stretch me-md-6">
                                    <!--begin::Overlay-->
                                    <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                        href="{{ $image->file_url }}" target="_blank">
                                        <!--begin::Image-->
                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                            style="background-image:url('{{ $image->file_url }}')">
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

                    {{-- <div class="">
                        <!--begin::Content-->
                        <!--begin::Row-->
                        <div class="row g-10">
                            <!--begin::Col-->
                            
                            <div class="col-md-4 mb-5">
                                <!--begin::Hot sales post-->
                                <div class="card-xl-stretch me-md-6">
                                    <!--begin::Overlay-->
                                    <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                        href="{{ $gallery->gallery_image }}" target="_blank">
                                        <!--begin::Image-->
                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                            style="background-image:url('{{ $gallery->gallery_image }}')">
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
                                               Gallery Image</span>
                                            
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
                    </div> --}}
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
    $('#short_description').summernote({
      placeholder: 'Enter short description...',
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
    $('#description').summernote({
      placeholder: 'Enter description here...',
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
                            <input type="file" class="form-control form-control-solid" placeholder="" name="gallery_images[]"
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
                window.location.href = "{{ url('admin/galleries/remove-gallery-image') }}/{{ $gallery->id }}/"+id;
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