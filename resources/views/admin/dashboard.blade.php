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
													<a href="{{ route('admin.lead.index') }}" style="text-decoration: none;">
														<div class="card-body d-flex flex-column p-0">
															<!--begin::Stats-->
															<div class="flex-grow-1 card-spacer-x pt-6">
																<div class="text-inverse-danger font-weight-bold font-size-h5 sku_id">Leads/Contacts</div>
																<div class="text-inverse-danger font-weight-bolder font-size-h2 sku_id"> {{ $no_of_leads }}</div>
															</div>
															<!--end::Stats-->
															<!--begin::Chart-->
															<div id="kt_tiles_widget_2_chart" class="card-rounded-bottom" style="height: 50px"></div>
															<!--end::Chart-->
														</div>
													</a>
													<!--end::Body-->
												</div>
											</div>
											<div class="col-xl-4">
												<div class="card card-custom bg-primary gutter-b" style="height: 130px">
													<!--begin::Body-->
													<a href="{{ route('admin.newsletter.index') }}" style="text-decoration: none;">
														<div class="card-body d-flex flex-column p-0">
															<!--begin::Stats-->
															<div class="flex-grow-1 card-spacer-x pt-6">
																<div class="text-inverse-danger font-weight-bold font-size-h5 sku_id">Emails subscribed for newsletters</div>
																<div class="text-inverse-danger font-weight-bolder font-size-h2 sku_id"> {{ $no_of_emails }}</div>
															</div>
															<!--end::Stats-->
															<!--begin::Chart-->
															<div id="kt_tiles_widget_2_chart" class="card-rounded-bottom" style="height: 50px"></div>
															<!--end::Chart-->
														</div>
													</a>
													<!--end::Body-->
												</div>
											</div>
											<div class="col-xl-4">
												<div class="card card-custom bg-secondary gutter-b" style="height: 130px">
													<!--begin::Body-->
													<a href="{{ route('admin.career.index') }}" style="text-decoration: none;">
														<div class="card-body d-flex flex-column p-0">
															<!--begin::Stats-->
															<div class="flex-grow-1 card-spacer-x pt-6">
																<div class="text-inverse-danger font-weight-bold font-size-h5 sku_id">Job applications received</div>
																<div class="text-inverse-danger font-weight-bolder font-size-h2 sku_id"> {{ $no_of_applications }}</div>
															</div>
															<!--end::Stats-->
															<!--begin::Chart-->
															<div id="kt_tiles_widget_2_chart" class="card-rounded-bottom" style="height: 50px"></div>
															<!--end::Chart-->
														</div>
													</a>
													<!--end::Body-->
												</div>
											</div>
										</div>
										<!--end::Row-->
										<div class="row">
											<div class="col-xl-6">
												<!--begin::Stats Widget 25-->
												<a href="{{ route('admin.blog.index') }}" style="text-decoration: none;">
													<div class="card card-custom bg-light-success card-stretch gutter-b">
														<!--begin::Body-->
															<div class="card-body">
																<!--begin::Chart-->
																<div id="kt_tiles_widget_2_chart" class="card-rounded-bottom" style="height: 50px"></div>
																<a style="text-decoration: none;" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ $no_of_blogs }}</a>
																<a style="text-decoration: none;" class="font-weight-bold text-muted font-size-md">No of Blogs</a>
																<!--end::Chart-->
															</div>
														<!--end::Body-->
													</div>
												</a>
												<!--end::Stats Widget 25-->
											</div>
											<div class="col-xl-6">
												<!--begin::Stats Widget 26-->
												<a href="{{ route('admin.service.index') }}" style="text-decoration: none;">
													<div class="card card-custom bg-light-danger card-stretch gutter-b">
														<!--begin::ody-->
															<div class="card-body">
																<!--begin::Chart-->
																<div id="kt_tiles_widget_2_chart" class="card-rounded-bottom" style="height: 50px"></div>
																<a style="text-decoration: none;" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ $no_of_services }}</a>
																<a style="text-decoration: none;" class="font-weight-bold text-muted font-size-md">No of services</a>
																<!--end::Chart-->
															</div>
														<!--end::Body-->
													</div>
												</a>
												<!--end::Stats Widget 26-->
											</div>
										</div>

										<div class="row">
											<div class="col-xl-6">
												<!--begin::Stats Widget 25-->
												<a href="{{ route('admin.project.index') }}" style="text-decoration: none;">
													<div class="card card-custom bg-light-info card-stretch gutter-b">
														<!--begin::Body-->
															<div class="card-body">
																<!--begin::Chart-->
																	<div id="kt_tiles_widget_2_chart" class="card-rounded-bottom" style="height: 50px"></div>
																	<a style="text-decoration: none;" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ $no_of_projects }}</a>
																	<a style="text-decoration: none;" class="font-weight-bold text-muted font-size-md">No of projects</a>
																<!--end::Chart-->
															</div>
														</a>
														<!--end::Body-->
													</div>
												</a>
												<!--end::Stats Widget 25-->
											</div>
											<div class="col-xl-6">
												<!--begin::Stats Widget 26-->
												<a href="{{ route('admin.case.studies.index') }}" style="text-decoration: none;">
													<div class="card card-custom bg-light-muted card-stretch gutter-b">
														<!--begin::ody-->
														{{-- <a href=""> --}}
															<div class="card-body">
																<!--begin::Chart-->
																<div id="kt_tiles_widget_2_chart" class="card-rounded-bottom" style="height: 50px"></div>
																<a style="text-decoration: none;" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ $no_of_case_studies }}</a>
																<a style="text-decoration: none;" class="font-weight-bold text-muted font-size-md">No of case studies</a>
																<!--end::Chart-->
															</div>
														{{-- </a> --}}
														<!--end::Body-->
													</div>
												</a>
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
