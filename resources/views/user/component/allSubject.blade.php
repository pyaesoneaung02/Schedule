@extends('user.layouts.master')

@section('content')
    <section id="all-subjects" class="pricing-section bg-light pb-100 pt-100">

        <div class="container">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="row justify-content-center">

                <div class="col-xxl-8 col-xl-8 col-lg-10 col-md-12">

                    <div class="section-title text-center mb-4">

                        <h3 class="mb-15 wow fadeInUp" data-wow-delay=".2s">
                            Curriculum Subjects
                        </h3>

                        <p class="wow fadeInUp text-muted" data-wow-delay=".4s">
                            Explore our subjects and click for details
                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                SEARCH
            ====================================================== --}}
            <div class="row justify-content-center mb-4 wow fadeInUp" data-wow-delay=".3s">

                <div class="col-lg-6 col-md-8">

                    <div class="input-group shadow-sm" style="border-radius: 50px; overflow: hidden;">

                        <span class="input-group-text bg-white border-0 ps-4 text-primary">
                            <i class="lni lni-search-alt"></i>
                        </span>

                        <input type="text" id="searchInput" class="form-control border-0 py-3 ps-2"
                            placeholder="Search by Code or Title..." style="box-shadow: none;">

                    </div>

                </div>

            </div>


            {{-- =====================================================
                YEAR FILTER
            ====================================================== --}}
            <div class="row justify-content-center mb-5 wow fadeInUp" data-wow-delay=".4s">

                <div class="col-12 text-center">

                    <div class="portfolio-btn-wrapper">

                        <button class="btn btn-outline-primary active filter-btn mb-2 me-2 rounded-pill px-4"
                            data-filter="all">

                            All Subjects

                        </button>


                        @php
                            $uniqueYears = $allSubjects->pluck('year.name')->filter()->unique();
                        @endphp


                        @foreach ($uniqueYears as $year)
                            <button class="btn btn-outline-primary filter-btn mb-2 me-2 rounded-pill px-4"
                                data-filter="{{ Str::slug($year) }}">

                                {{ $year }}

                            </button>
                        @endforeach

                    </div>

                </div>

            </div>


            {{-- =====================================================
                SUBJECT GRID
            ====================================================== --}}
            <div class="row wow fadeInUp" data-wow-delay=".5s" id="subjectGrid">

                @forelse ($allSubjects as $subject)
                    @php
                        $yearClass = Str::slug($subject->year->name ?? 'other');

                        $subjectImage = !empty($subject->image)
                            ? asset('images/subjects/' . $subject->image)
                            : asset('images/subjects/default.jpg');
                    @endphp


                    {{-- =================================================
                        SUBJECT CARD
                    ================================================== --}}
                    <div class="col-lg-4 col-md-6 mb-4 subject-item {{ $yearClass }}">

                        <div class="card h-100 border-0 bg-white"
                            style="
                                border-radius: 15px;
                                cursor: pointer;
                                transition: all 0.3s ease;
                                box-shadow: 0 4px 10px rgba(0,0,0,0.05);
                            "
                            onmouseover="
                                this.style.transform='translateY(-8px)';
                                this.style.boxShadow='0 15px 25px rgba(0,0,0,0.1)';
                            "
                            onmouseout="
                                this.style.transform='translateY(0)';
                                this.style.boxShadow='0 4px 10px rgba(0,0,0,0.05)';
                            "
                            data-bs-toggle="modal" data-bs-target="#subjectDetailModal" {{-- Subject Data --}}
                            data-code="{{ $subject->short_name ?? ($subject->name ?? 'N/A') }}"
                            data-title="{{ $subject->long_name ?? 'N/A' }}"
                            data-semester="{{ $subject->semester->name ?? 'N/A' }}"
                            data-year="{{ $subject->year->name ?? 'Other' }}"
                            data-desc="{{ strip_tags($subject->description ?? 'No detailed description available.') }}"
                            data-image="{{ $subjectImage }}">


                            {{-- =================================================
                                SUBJECT IMAGE
                            ================================================== --}}
                            <img src="{{ asset($subject->image) }}" alt="{{ $subject->long_name ?? $subject->name }}"
                                class="subject-image"
                                style="
                                    width: 100%;
                                    height: 220px;
                                    object-fit: cover;
                                    border-radius: 15px 15px 0 0;
                                ">


                            {{-- =================================================
                                CARD BODY
                            ================================================== --}}
                            <div class="card-body p-4 text-center">


                                {{-- =================================================
                                    Subject Code
                                    ICON REMOVED ONLY
                                ================================================== --}}

                                <h5 class="fw-bold text-dark mb-2">

                                    {{ $subject->short_name ?? ($subject->name ?? 'N/A') }}

                                </h5>


                                {{-- =================================================
                                    Subject Title
                                ================================================== --}}

                                <p class="text-muted mb-3"
                                    style="
                                        font-size: 14px;
                                        min-height: 42px;
                                    ">

                                    {{ Str::limit($subject->long_name ?? 'N/A', 50) }}

                                </p>


                                <hr class="opacity-25">


                                {{-- =================================================
                                    Year / Semester
                                ================================================== --}}
                                <div class="d-flex justify-content-between align-items-center mt-3"
                                    style="font-size: 13px;">

                                    <span class="text-primary fw-semibold">

                                        {{ $subject->year->name ?? 'N/A' }}

                                    </span>


                                    <span class="badge bg-light text-dark border">

                                        {{ $subject->semester->name ?? 'N/A' }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    {{-- No Subjects --}}
                    <div class="col-12 text-center py-5">

                        <p class="text-muted">

                            No subjects found in the curriculum.

                        </p>

                    </div>
                @endforelse


                {{-- =====================================================
                    NO SEARCH RESULT
                ====================================================== --}}
                <div class="col-12 text-center py-5" id="noResultsMessage" style="display: none;">

                    <i class="lni lni-search-alt text-muted" style="font-size: 3rem;">
                    </i>

                    <h5 class="mt-3 text-muted">

                        No matching subjects found.

                    </h5>

                </div>

            </div>

        </div>

    </section>



    {{-- =============================================================
        SUBJECT DETAIL MODAL
    ============================================================= --}}
    <div class="modal fade" id="subjectDetailModal" tabindex="-1" aria-labelledby="subjectDetailModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content border-0 shadow-lg"
                style="
                    border-radius: 15px;
                    overflow: hidden;
                ">


                {{-- Close --}}
                <div class="modal-header border-0 position-absolute w-100" style="z-index: 10;">

                    <button type="button" class="btn-close bg-white rounded-circle p-2 shadow-sm" data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>


                {{-- =====================================================
                    MODAL IMAGE
                ====================================================== --}}
                <img src="{{ asset($subject->image) }}" alt="{{ $subject->long_name ?? $subject->name }}"
                    class="subject-image"
                    style="
                        height: 250px;
                        object-fit: cover;
                    ">


                {{-- =====================================================
                    MODAL BODY
                ====================================================== --}}
                <div class="modal-body p-4 p-md-5">


                    {{-- Code + Semester --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h4 id="modalCode" class="fw-bold text-primary mb-0">
                        </h4>


                        <span id="modalSemester" class="badge bg-dark rounded-pill px-3 py-2">
                        </span>

                    </div>


                    {{-- Title --}}
                    <h3 id="modalTitle" class="fw-bold text-dark mb-4">
                    </h3>


                    {{-- Description --}}
                    <h6 class="fw-bold text-secondary mb-2">

                        Description

                    </h6>


                    <p id="modalDesc" class="text-muted lh-lg">
                    </p>


                    <hr class="my-4">


                    {{-- Year --}}
                    <div class="d-flex align-items-center text-muted">

                        <i class="lni lni-graduation me-2 fs-5"></i>

                        <span id="modalYear"></span>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =============================================================
        JAVASCRIPT
    ============================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput =
                document.getElementById('searchInput');

            const filterBtns =
                document.querySelectorAll('.filter-btn');

            const subjectItems =
                document.querySelectorAll('.subject-item');

            const noResultsMessage =
                document.getElementById('noResultsMessage');

            let currentFilter = 'all';


            /* =====================================================
               FILTER BUTTON
            ===================================================== */

            filterBtns.forEach(function(btn) {

                btn.addEventListener('click', function() {

                    filterBtns.forEach(function(button) {

                        button.classList.remove(
                            'active',
                            'text-white'
                        );

                    });

                    this.classList.add('active');

                    currentFilter =
                        this.getAttribute('data-filter');

                    filterSubjects();

                });

            });


            /* =====================================================
               SEARCH
            ===================================================== */

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filterSubjects
                );

            }


            /* =====================================================
               FILTER FUNCTION
            ===================================================== */

            function filterSubjects() {

                const searchTerm =
                    searchInput ?
                    searchInput.value.toLowerCase().trim() :
                    '';

                let visibleCount = 0;


                subjectItems.forEach(function(item) {

                    const text =
                        item.textContent.toLowerCase();

                    const matchesSearch =
                        text.includes(searchTerm);

                    const matchesFilter =
                        currentFilter === 'all' ||
                        item.classList.contains(currentFilter);


                    if (
                        matchesSearch &&
                        matchesFilter
                    ) {

                        item.style.display = 'block';

                        item.animate(
                            [{
                                    opacity: 0,
                                    transform: 'scale(0.95)'
                                },
                                {
                                    opacity: 1,
                                    transform: 'scale(1)'
                                }
                            ], {
                                duration: 300
                            }
                        );

                        visibleCount++;

                    } else {

                        item.style.display = 'none';

                    }

                });


                noResultsMessage.style.display =
                    visibleCount === 0 ?
                    'block' :
                    'none';

            }


            /* =====================================================
               SUBJECT MODAL
            ===================================================== */

            const subjectModal =
                document.getElementById(
                    'subjectDetailModal'
                );


            if (subjectModal) {

                subjectModal.addEventListener(
                    'show.bs.modal',
                    function(event) {

                        const button =
                            event.relatedTarget;


                        /* Code */
                        subjectModal.querySelector(
                                '#modalCode'
                            ).textContent =
                            button.getAttribute(
                                'data-code'
                            );


                        /* Title */
                        subjectModal.querySelector(
                                '#modalTitle'
                            ).textContent =
                            button.getAttribute(
                                'data-title'
                            );


                        /* Semester */
                        subjectModal.querySelector(
                                '#modalSemester'
                            ).textContent =
                            button.getAttribute(
                                'data-semester'
                            );


                        /* Year */
                        subjectModal.querySelector(
                                '#modalYear'
                            ).textContent =
                            button.getAttribute(
                                'data-year'
                            ) + ' Curriculum';


                        /* Description */
                        subjectModal.querySelector(
                                '#modalDesc'
                            ).textContent =
                            button.getAttribute(
                                'data-desc'
                            );


                        /* Image */
                        subjectModal.querySelector(
                                '#modalImage'
                            ).src =
                            button.getAttribute(
                                'data-image'
                            );

                    }
                );

            }

        });
    </script>
@endsection
