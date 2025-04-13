@extends("layouts.overall")
@section("page_title", "Dashboard")
@section("content")
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
                        @include('admin.includes.bodytop')
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Dashboard-->
								<!--begin::Row-->
								<div class="row">
									<div class="col-xl-12">
										<div class="row">
											<div class="col-xl-4">
												<div class="card card-custom bg-warning gutter-b" style="height: 130px">
													<!--begin::Body-->
													<!--end::Body-->
												</div>
											</div>
											<div class="col-xl-4">
												<div class="card card-custom bg-primary gutter-b" style="height: 130px">
													<!--begin::Body-->
													<!--end::Body-->
												</div>
											</div>
											<div class="col-xl-4">
												<div class="card card-custom bg-secondary gutter-b" style="height: 130px">
													<!--begin::Body-->
													<!--end::Body-->
												</div>
											</div>
										</div>
										<!--end::Row-->
										<div class="row">
											<div class="col-xl-6">
												<!--begin::Stats Widget 25-->
												<!--end::Stats Widget 25-->
											</div>
											<div class="col-xl-6">
												<!--begin::Stats Widget 26-->
												<!--end::Stats Widget 26-->
											</div>
										</div>

										<div class="row">
											<div class="col-xl-6">
												<!--begin::Stats Widget 25-->
												<!--end::Stats Widget 25-->
											</div>
											<div class="col-xl-6">
												<!--begin::Stats Widget 26-->
												<!--end::Stats Widget 26-->
											</div>
										</div>
										
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

		<!--end::Main-->
@endsection
