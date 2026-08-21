@extends('user.layouts.master')

@section('content')

<section id="subject" class="pricing-section bg-light pb-100 pt-100">

    <div class="container">

        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="mb-5 row justify-content-center">

            <div class="text-center col-lg-7">

                <div class="section-title">

                    <h3 class="mb-2 fw-bold wow fadeInUp"
                        data-wow-delay=".2s">

                        Assigned Subjects

                    </h3>

                    <p class="text-muted wow fadeInUp"
                       data-wow-delay=".3s">

                        Overview of your assigned subjects and classroom details

                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
            SUBJECT LOOP
        ====================================================== --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

            @forelse($teachings as $teachingIndex => $teaching)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | SUBJECT IMAGES
                    |--------------------------------------------------------------------------
                    */

                    $images = [];

                    $subject = $teaching->subject;


                    /*
                    |--------------------------------------------------------------------------
                    | IMAGE COLUMN
                    |--------------------------------------------------------------------------
                    */

                    if (!empty($subject->image)) {

                        if (is_array($subject->image)) {

                            $images = $subject->image;

                        }

                        elseif (is_string($subject->image)) {

                            $decodedImages =
                                json_decode(
                                    $subject->image,
                                    true
                                );


                            if (
                                json_last_error() === JSON_ERROR_NONE
                                &&
                                is_array($decodedImages)
                            ) {

                                $images =
                                    $decodedImages;

                            }

                            else {

                                $images =
                                    array_filter(
                                        array_map(
                                            'trim',
                                            explode(
                                                ',',
                                                $subject->image
                                            )
                                        )
                                    );

                            }

                        }

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | IMAGE RELATIONSHIP
                    |--------------------------------------------------------------------------
                    */

                    elseif (
                        isset($subject->images)
                        &&
                        $subject->images->count() > 0
                    ) {

                        $images =
                            $subject->images
                                ->pluck('image')
                                ->toArray();

                    }

                @endphp


                {{-- =================================================
                    SUBJECT CARD
                ================================================== --}}
                <div class="col">

                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden custom-subject-card">


                        {{-- =============================================
                            IMAGE
                        ============================================== --}}
                        <div class="position-relative subject-image-wrapper">


                            {{-- =========================================
                                IMAGE LOOP
                            ========================================== --}}
                            @if(count($images) > 0)

                                <div
                                    id="subjectCarousel{{ $teachingIndex }}"
                                    class="carousel slide h-100"
                                    data-bs-ride="carousel"
                                >


                                    {{-- ===============================
                                        INDICATORS LOOP
                                    ================================ --}}
                                    @if(count($images) > 1)

                                        <div class="carousel-indicators">

                                            @foreach($images as $imageIndex => $image)

                                                <button
                                                    type="button"

                                                    data-bs-target="#subjectCarousel{{ $teachingIndex }}"

                                                    data-bs-slide-to="{{ $imageIndex }}"

                                                    class="{{ $loop->first ? 'active' : '' }}"

                                                    aria-current="{{ $loop->first ? 'true' : 'false' }}"

                                                    aria-label="Slide {{ $imageIndex + 1 }}"
                                                ></button>

                                            @endforeach

                                        </div>

                                    @endif


                                    {{-- ===============================
                                        IMAGE SLIDES LOOP
                                    ================================ --}}
                                    <div class="carousel-inner h-100">

                                        @foreach($images as $imageIndex => $image)

                                            @php

                                                /*
                                                |--------------------------------------------------------------------------
                                                | IMAGE PATH
                                                |--------------------------------------------------------------------------
                                                */

                                                if (
                                                    file_exists(
                                                        public_path(
                                                            'storage/' . $image
                                                        )
                                                    )
                                                ) {

                                                    $imagePath =
                                                        asset(
                                                            'storage/' . $image
                                                        );

                                                }

                                                else {

                                                    $imagePath =
                                                        asset(
                                                            $image
                                                        );

                                                }

                                            @endphp


                                            <div
                                                class="carousel-item h-100
                                                {{ $loop->first ? 'active' : '' }}"
                                            >

                                                <img
                                                    src="{{ $imagePath }}"

                                                    class="d-block w-100 h-100 object-fit-cover"

                                                    alt="{{ $subject->long_name ?? 'Subject Image' }}"
                                                >

                                            </div>

                                        @endforeach

                                    </div>


                                    {{-- ===============================
                                        PREVIOUS / NEXT
                                    ================================ --}}
                                    @if(count($images) > 1)

                                        <button
                                            class="carousel-control-prev"

                                            type="button"

                                            data-bs-target="#subjectCarousel{{ $teachingIndex }}"

                                            data-bs-slide="prev"
                                        >

                                            <span
                                                class="carousel-control-prev-icon"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="visually-hidden">

                                                Previous

                                            </span>

                                        </button>


                                        <button
                                            class="carousel-control-next"

                                            type="button"

                                            data-bs-target="#subjectCarousel{{ $teachingIndex }}"

                                            data-bs-slide="next"
                                        >

                                            <span
                                                class="carousel-control-next-icon"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="visually-hidden">

                                                Next

                                            </span>

                                        </button>

                                    @endif

                                </div>


                            {{-- =========================================
                                NO IMAGE
                            ========================================== --}}
                            @else

                                <img
                                    src="{{ asset('assets/images/default-subject.jpg') }}"

                                    class="w-100 h-100 object-fit-cover"

                                    alt="No Subject Image"
                                >

                            @endif


                            {{-- =========================================
                                YEAR BADGE
                            ========================================== --}}
                            <span class="year-badge">

                                {{ $teaching->year->name ?? 'Year' }}

                            </span>

                        </div>


                        {{-- =============================================
                            CARD BODY
                        ============================================== --}}
                        <div class="p-4 card-body d-flex flex-column">


                            {{-- =========================================
                                MAJOR / SECTION
                            ========================================== --}}
                            <div class="mb-3 subject-badges">

                                <span class="border badge bg-light text-dark">

                                    {{ $teaching->major->name ?? 'Major' }}

                                </span>


                                <span class="border badge section-badge">

                                    Section:
                                    {{ $teaching->section->name ?? 'N/A' }}

                                </span>

                            </div>


                            {{-- =========================================
                                SUBJECT NAME
                            ========================================== --}}
                            <h5 class="mb-3 card-title fw-bold text-dark">

                                {{
                                    $subject->long_name
                                    ??
                                    $subject->name
                                    ??
                                    'Subject Name'
                                }}

                            </h5>


                            <hr class="mt-auto opacity-10">


                            {{-- =========================================
                                DETAILS
                            ========================================== --}}
                            <ul class="mb-0 list-unstyled subject-details">


                                {{-- ROOM --}}
                                <li>

                                    <i class="lni lni-map-marker"></i>

                                    <span>

                                        <strong>Room:</strong>

                                        {{ $teaching->room->name ?? 'N/A' }}

                                    </span>

                                </li>


                                {{-- SEMESTER --}}
                                <li>

                                    <i class="lni lni-calendar"></i>

                                    <span>

                                        <strong>Semester:</strong>

                                        {{ $teaching->semester->name ?? 'N/A' }}

                                    </span>

                                </li>

                            </ul>

                        </div>

                    </div>

                </div>


            {{-- =====================================================
                EMPTY
            ====================================================== --}}
            @empty

                <div class="py-5 text-center col-12">

                    <div class="p-5 bg-white shadow-sm rounded-4 d-inline-block empty-subject-box">

                        <i class="mb-3 lni lni-book text-muted display-4 d-block"></i>

                        <h5 class="fw-bold text-secondary">

                            No Assigned Subjects Found

                        </h5>

                        <p class="mb-0 text-muted small">

                            There are currently no subjects assigned to display.

                        </p>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>


{{-- =========================================================
    CSS
========================================================= --}}
<style>

.object-fit-cover {

    object-fit: cover;

}


/* =========================================================
   SUBJECT CARD
========================================================= */

.custom-subject-card {

    transition:
        transform .3s ease,
        box-shadow .3s ease;

}


.custom-subject-card:hover {

    transform: translateY(-6px);

    box-shadow:
        0 15px 30px
        rgba(0, 0, 0, .12)
        !important;

}


/* =========================================================
   IMAGE
========================================================= */

.subject-image-wrapper {

    height: 200px;

    overflow: hidden;

}


.subject-image-wrapper img {

    width: 100%;

    height: 100%;

    object-fit: cover;

}


/* =========================================================
   YEAR BADGE
========================================================= */

.year-badge {

    position: absolute;

    top: 15px;

    right: 15px;

    z-index: 10;

    padding: 8px 14px;

    background: #0d6efd;

    color: #fff;

    font-size: 12px;

    font-weight: 600;

    border-radius: 50px;

    box-shadow:
        0 4px 10px
        rgba(0, 0, 0, .15);

}


/* =========================================================
   BADGES
========================================================= */

.subject-badges {

    display: flex;

    flex-wrap: wrap;

    gap: 6px;

}


.section-badge {

    background: rgba(13, 110, 253, .08);

    color: #0d6efd;

    border-color:
        rgba(13, 110, 253, .25)
        !important;

}


/* =========================================================
   DETAILS
========================================================= */

.subject-details {

    display: flex;

    flex-direction: column;

    gap: 10px;

    color: #6c757d;

    font-size: 14px;

}


.subject-details li {

    display: flex;

    align-items: center;

}


.subject-details i {

    width: 24px;

    margin-right: 8px;

    color: #0d6efd;

    font-size: 17px;

}


/* =========================================================
   CAROUSEL
========================================================= */

.carousel-control-prev,
.carousel-control-next {

    width: 12%;

    opacity: .7;

}


.carousel-control-prev:hover,
.carousel-control-next:hover {

    opacity: 1;

}


.carousel-indicators {

    margin-bottom: 8px;

}


/* =========================================================
   EMPTY
========================================================= */

.empty-subject-box {

    width: 450px;

    max-width: 100%;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .subject-image-wrapper {

        height: 190px;

    }

}

</style>

@endsection
