@extends("layouts.overall")
@section("page_title", "Edit Blog")
@section('module', 'Blog')
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
            <a href="{{ route('admin.blog.index') }}" class="btn btn-warning font-weight-bolder font-size-sm mr-3">
                <i class="ki-duotone ki-add-folder"></i> View all Blogs
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

                        <form class="form" action="{{ route('admin.blog.edit', $blog->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Title <span class="text-danger"><b>*</b></span></label>
                                            <input type="text" class="form-control" name="title" placeholder="" value="{{ $blog->title }}" />
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Sub Title</label>
                                            <input type="text" class="form-control" name="sub_title" placeholder="" value="{{ $blog->sub_title }}" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Category <span class="text-danger"><b>*</b></span></label>
                                            <select id="category" name="category" class="form-control">
                                                <option value="none" selected="" disabled="">Choose a Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{$category->id == $blog->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Author <span class="text-danger"><b>*</b></span></label>
                                            <input type="text" class="form-control" name="author" placeholder="" value="{{ $blog->author }}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Publication Date <span class="text-danger"><b>*</b></span></label>
                                            <input type="date" class="form-control" name="publication_date" placeholder="" value="{{ $blog->publication_date }}" />
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Featured Image <small>(1280px x 615px)</small></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control form-control-solid" placeholder="" name="featured_image" accept=".png, .jpg, .jpeg .gif" value="{{ old('featured_image') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label> Short Description <span class="text-danger"><b>*</b></span></label>
                                            <textarea rows="3" minlength="200" maxlength="300" type="text" class="form-control" name="short_description" placeholder="">{{ $blog->short_description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label> Content <span class="text-danger"><b>*</b></span></label>
                                            <textarea rows="10" type="text" id="description" class="form-control" name="content" placeholder="">{{ $blog->content }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>Tags (comma-separated)</label>
                                            <input type="text" class="form-control" name="tags" placeholder="Ideation, Surveys, Merchandising etc" value="{{ implode(',', $blog->tags->pluck('name')->toArray()) }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <div class="d-flex flex-stack">
        
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" @if ($blog->status == 1) checked @endif name="status" />
                                                <span class="form-check-label fw-semibold text-muted">Active</span>
                                            </label>
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" @if ($blog->is_featured == 1) checked @endif name="is_featured" />
                                                <span class="form-check-label fw-semibold text-muted">Featured</span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>

                                        <div class="d-flex flex-stack md-6 mt-4">
                                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                                            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Cancel</a>
                                        </div>
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
    $('#description').summernote({
      placeholder: 'Enter content here...',
      tabsize: 2,
      height: 300,
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
    $('#short_description').summernote({
      placeholder: 'Enter short description here...',
      tabsize: 2,
      height: 100,
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