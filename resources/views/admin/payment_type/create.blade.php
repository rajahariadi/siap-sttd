@extends('admin.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Pembayaran</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item">Pembayaran</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Create Data</h4>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="paymentTypeTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-primary" id="semester-tab" data-toggle="tab" href="#semester"
                                role="tab" aria-selected="true">
                                Semester
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="lain-tab" data-toggle="tab" href="#lain" role="tab"
                                aria-selected="false">
                                Lain-lain
                            </a>
                        </li>
                    </ul>

                    <form action="{{ route('admin.jenis-pembayaran.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" id="current_tab_type" value="semester">

                        <div class="tab-content mt-4" id="paymentTypeTabContent">
                            <!-- Semester Tab -->
                            <div class="tab-pane fade show active" id="semester" role="tabpanel">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Semester<sup class="text-danger">*</sup></label>
                                    <div class="col-md-10">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="semester_type"
                                                id="ganjil" value="Ganjil">
                                            <label class="form-check-label" for="ganjil">Ganjil</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="semester_type"
                                                id="genap" value="Genap">
                                            <label class="form-check-label" for="genap">Genap</label>
                                        </div>
                                        @error('semester_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Tahun Ajaran<sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <input type="text" class="form-control mr-2" data-provide="datepicker"
                                                data-date-format="yyyy" data-date-min-view-mode="2" name="start_year"
                                                id="start_year">
                                            <span class="mx-2">/</span>
                                            <input type="text" class="form-control ml-2" data-provide="datepicker"
                                                data-date-format="yyyy" data-date-min-view-mode="2" id="end_year_display"
                                                readonly style="background-color: #f8f9fa; cursor: not-allowed" disabled>
                                            <input type="hidden" name="end_year" id="end_year">
                                        </div>
                                        @error('start_year')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        @error('end_year')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Deskripsi</label>
                                    <div class="col-md-10">
                                        <textarea name="description" rows="4" class="form-control" id="description_semester"></textarea>
                                        @error('description')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Lain-lain Tab -->
                            <div class="tab-pane fade" id="lain" role="tabpanel">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Pembayaran<sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Deskripsi</label>
                                    <div class="col-md-10">
                                        <textarea name="description_other" rows="4" class="form-control" id="description_other"></textarea>
                                        @error('description')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button class="btn btn-secondary"
                                onclick="window.location.href='{{ route('admin.jenis-pembayaran.index') }}'"
                                type="button">Cancel</button>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize tab state
            const $tabLinks = $('a[data-toggle="tab"]');
            const $currentTabType = $('#current_tab_type');
            const $form = $('form');

            // Function to update tab type and UI
            function updateActiveTabState(activeTab) {
                // Update active tab style
                $tabLinks.removeClass('text-primary');
                activeTab.addClass('text-primary');

                // Update the hidden type field
                const tabType = activeTab.attr('href') === '#semester' ? 'semester' : 'lain';
                $currentTabType.val(tabType);

                // Nonaktifkan validasi untuk tab yang tidak aktif
                if (tabType === 'semester') {
                    $form.find('[name="name"]').removeAttr('required');
                    $form.find('[name="semester_type"], [name="start_year"]').attr('required', true);
                } else {
                    $form.find('[name="semester_type"], [name="start_year"]').removeAttr('required');
                    $form.find('[name="name"]').attr('required', true);
                }
            }

            // Set initial active tab
            const initialActiveTab = $tabLinks.filter('.active');
            updateActiveTabState(initialActiveTab);

            // Handle tab switching
            $tabLinks.on('shown.bs.tab', function(e) {
                const $activeTab = $(e.target);
                updateActiveTabState($activeTab);

                // Reset all inputs in inactive tab panes
                $('.tab-pane').not($activeTab.attr('href')).each(function() {
                    $(this).find('input:not([type="hidden"]), textarea, select').val('');
                    $(this).find('input[type="radio"], input[type="checkbox"]').prop('checked',
                        false);
                });
            });

            // Auto-fill end year when start year changes
            $('#start_year').on('change', function() {
                const year = parseInt($(this).val());
                if (!isNaN(year)) {
                    const endYear = year + 1;
                    $('#end_year_display').val(endYear);
                    $('#end_year').val(endYear);
                }
            });

            // Form submission - disable fields dari tab yang tidak aktif
            $form.on('submit', function() {
                const activeTab = $tabLinks.filter('.active').attr('href');

                if (activeTab === '#semester') {
                    $form.find('#name_other, #description_other').prop('disabled', true);
                } else {
                    $form.find(
                            '[name="semester_type"], [name="start_year"], [name="end_year"], #description_semester'
                        )
                        .prop('disabled', true);
                }
            });
        });
    </script>
@endsection
