<x-admin.layout.home>
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">



                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                    <!--begin::Title-->
                    <h1
                        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Getting Started
                    </h1>
                    <!--end::Title-->


                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="/keen/demo1/index.html" class="text-muted text-hover-primary">
                                Home </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            Subscription </li>
                        <!--end::Item-->

                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Filter menu-->
                    <div class="d-flex">
                        <select name="campaign-type" data-control="select2" data-hide-search="true"
                            class="form-select form-select-sm bg-body border-body w-175px select2-hidden-accessible"
                            data-select2-id="select2-data-7-z211" tabindex="-1" aria-hidden="true"
                            data-kt-initialized="1">
                            <option value="Twitter" selected="selected" data-select2-id="select2-data-9-u4yb">
                                Select Campaign</option>
                            <option value="Twitter">Twitter Campaign</option>
                            <option value="Twitter">Facebook Campaign</option>
                            <option value="Twitter">Adword Campaign</option>
                            <option value="Twitter">Carbon Campaign</option>
                        </select><span class="select2 select2-container select2-container--bootstrap5"
                            dir="ltr" data-select2-id="select2-data-8-1set" style="width: 100%;"><span
                                class="selection"><span
                                    class="select2-selection select2-selection--single form-select form-select-sm bg-body border-body w-175px"
                                    role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                    aria-disabled="false" aria-labelledby="select2-campaign-type-1s-container"
                                    aria-controls="select2-campaign-type-1s-container"><span
                                        class="select2-selection__rendered" id="select2-campaign-type-1s-container"
                                        role="textbox" aria-readonly="true" title="Select Campaign">Select
                                        Campaign</span><span class="select2-selection__arrow" role="presentation"><b
                                            role="presentation"></b></span></span></span><span
                                class="dropdown-wrapper" aria-hidden="true"></span></span>

                        <a href="#" class="btn btn-icon btn-sm btn-success flex-shrink-0 ms-4"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">
                            <i class="ki-duotone ki-plus fs-2"></i>
                        </a>
                    </div>
                    <!--end::Filter menu-->


                    <!--begin::Secondary button-->
                    <!--end::Secondary button-->

                    <!--begin::Primary button-->
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-xxl ">
                <!--begin::Card-->
                <div class="card ">
                    <!--begin::Card body-->
                    <div class="card-body p-0">
                        <!--begin::Wrapper-->
                        <div class="card-px text-center py-20 my-10">
                            <!--begin::Title-->
                            <h2 class="fs-2x fw-bold mb-10">Welcome to Subscriptions App</h2>
                            <!--end::Title-->

                            <!--begin::Description-->
                            <p class="text-gray-500 fs-4 fw-semibold mb-10">
                                There are no subscriptions added yet.<br>
                                Kickstart your business by adding a your first subscription
                            </p>
                            <!--end::Description-->

                            <!--begin::Action-->
                            <a href="/keen/demo1/apps/subscriptions/add.html" class="btn btn-primary">Add
                                Subscription</a>
                            <!--end::Action-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Illustration-->
                        <div class="text-center px-4">
                            <img class="mw-100 mh-300px" alt=""
                                src="/keen/demo1/assets/media/illustrations/sketchy-1/5.png">
                        </div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->

    </div>
</x-admin.layout.home>