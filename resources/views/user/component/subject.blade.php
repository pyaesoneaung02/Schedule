@extends('user.layouts.master')

@section('content')

<section id="subject" class="pricing-section bg-light pt-35 pb-100">

    <div class="container">

        {{-- =====================================================
            HEADER
        ====================================================== --}}

        <div class="mb-5 row justify-content-center">

            <div class="text-center col-lg-8">

                <div class="section-title">

                    <h3 class="mb-2 fw-bold">
                        Subjects
                    </h3>

                    <p class="mb-0 text-muted">
                        Browse subjects by academic year
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
            YEAR FILTER
        ====================================================== --}}

        <div class="mb-5 year-filter-wrapper">

            <div class="year-filter">

                {{-- ALL --}}

                <a
                    href="{{ route('user.subject') }}"
                    class="year-filter-btn
                    {{ empty($yearID) ? 'active' : '' }}"
                >

                    All

                </a>


                {{-- YEAR LOOP --}}

                @foreach($years as $year)

                    <a
                        href="{{ route('user.subject', [
                            'yearID' => $year->id
                        ]) }}"
                        class="year-filter-btn
                        {{ (string) $yearID === (string) $year->id
                            ? 'active'
                            : ''
                        }}"
                    >

                        {{ $year->name }}

                    </a>

                @endforeach

            </div>

        </div>


        {{-- =====================================================
            SELECTED YEAR TITLE
        ====================================================== --}}

        @if(!empty($yearID))

            @php

                $selectedYear = $years->firstWhere(
                    'id',
                    $yearID
                );

            @endphp

            @if($selectedYear)

                <div class="mb-4 selected-year">

                    <div>

                        <span class="selected-year-label">
                            Showing Subjects For
                        </span>

                        <h4 class="mb-0 fw-bold">
                            {{ $selectedYear->name }}
                        </h4>

                    </div>

                    <span class="subject-count">

                        {{ $allSubjects->count() }}
                        Subject{{ $allSubjects->count() != 1 ? 's' : '' }}

                    </span>

                </div>

            @endif

        @else

            <div class="mb-4 selected-year">

                <div>

                    <span class="selected-year-label">
                        Showing
                    </span>

                    <h4 class="mb-0 fw-bold">
                        All Subjects
                    </h4>

                </div>

                <span class="subject-count">

                    {{ $allSubjects->count() }}
                    Subject{{ $allSubjects->count() != 1 ? 's' : '' }}

                </span>

            </div>

        @endif



        {{-- =====================================================
            SUBJECT LOOP
        ====================================================== --}}

        <div class="row g-4">

            @forelse($allSubjects as $subject)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | DEFAULT IMAGE
                    |--------------------------------------------------------------------------
                    */

                    $imagePath = asset(
                        'assets/images/default-subject.jpg'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | SUBJECT IMAGE
                    |--------------------------------------------------------------------------
                    */

                    if (!empty($subject->image)) {

                        $image = trim(
                            $subject->image,
                            "\"'"
                        );


                        if (
                            filter_var(
                                $image,
                                FILTER_VALIDATE_URL
                            )
                        ) {

                            $imagePath = $image;

                        }

                        elseif (
                            str_starts_with(
                                $image,
                                'storage/'
                            )
                        ) {

                            $imagePath = asset($image);

                        }

                        elseif (
                            str_starts_with(
                                $image,
                                '/storage/'
                            )
                        ) {

                            $imagePath = asset(
                                ltrim($image, '/')
                            );

                        }

                        elseif (
                            file_exists(
                                public_path(
                                    'storage/' . $image
                                )
                            )
                        ) {

                            $imagePath = asset(
                                'storage/' . $image
                            );

                        }

                        elseif (
                            file_exists(
                                public_path($image)
                            )
                        ) {

                            $imagePath = asset($image);

                        }

                        else {

                            $imagePath = asset(
                                'storage/' .
                                ltrim($image, '/')
                            );

                        }

                    }

                @endphp


                {{-- =================================================
                    SUBJECT CARD
                ================================================== --}}

                <div class="col-12 col-md-6 col-lg-4">

                    <div class="subject-card h-100">


                        {{-- IMAGE --}}

                        <div class="subject-image">

                            <img
                                src="{{ $imagePath }}"
                                alt="{{ $subject->long_name ?? $subject->name }}"
                                loading="lazy"
                                onerror="
                                    this.onerror=null;
                                    this.src='{{ asset('assets/images/default-subject.jpg') }}';
                                "
                            >


                            {{-- YEAR BADGE --}}

                            <span class="year-badge">

                                {{ $subject->year->name ?? 'Year' }}

                            </span>

                        </div>


                        {{-- CONTENT --}}

                        <div class="subject-content">


                            {{-- CODE --}}

                            @if(!empty($subject->short_name))

                                <div class="subject-code">

                                    {{ $subject->short_name }}

                                </div>

                            @endif


                            {{-- NAME --}}

                            <h4 class="subject-title">

                                {{ $subject->long_name
                                    ?? $subject->name
                                    ?? 'Subject Name'
                                }}

                            </h4>


                            <div class="subject-line"></div>


                            {{-- DETAILS --}}

                            <div class="subject-info">


                                <div class="info-item">

                                    <div class="info-icon">

                                        <i class="lni lni-graduation"></i>

                                    </div>

                                    <div>

                                        <small>Year</small>

                                        <strong>
                                            {{ $subject->year->name ?? 'N/A' }}
                                        </strong>

                                    </div>

                                </div>


                                <div class="info-item">

                                    <div class="info-icon">

                                        <i class="lni lni-calendar"></i>

                                    </div>

                                    <div>

                                        <small>Semester</small>

                                        <strong>
                                            {{ $subject->semester->name ?? 'N/A' }}
                                        </strong>

                                    </div>

                                </div>


                                @if(isset($subject->time_number))

                                    <div class="info-item">

                                        <div class="info-icon">

                                            <i class="lni lni-alarm-clock"></i>

                                        </div>

                                        <div>

                                            <small>Weekly Period</small>

                                            <strong>
                                                {{ $subject->time_number }}
                                            </strong>

                                        </div>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>


            @empty

                {{-- =================================================
                    NO SUBJECT
                ================================================== --}}

                <div class="col-12">

                    <div class="empty-subject">

                        <div class="empty-icon">

                            <i class="lni lni-book"></i>

                        </div>

                        <h4 class="mt-3">
                            No Subjects Found
                        </h4>

                        <p>
                            No subjects are available for this year.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>


<style>

/* =========================================================
   YEAR FILTER
========================================================= */

.year-filter-wrapper {

    display: flex;

    justify-content: center;

}


.year-filter {

    display: flex;

    flex-wrap: wrap;

    justify-content: center;

    gap: 10px;

    padding: 8px;

    background: #fff;

    border-radius: 50px;

    box-shadow:
        0 5px 20px rgba(0, 0, 0, .06);

}


.year-filter-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 100px;

    padding: 10px 20px;

    border-radius: 50px;

    text-decoration: none;

    color: #495057;

    background: transparent;

    font-size: 14px;

    font-weight: 600;

    transition: .25s ease;

}


.year-filter-btn:hover {

    color: #0d6efd;

    background:
        rgba(13, 110, 253, .08);

}


.year-filter-btn.active {

    color: #fff;

    background: #0d6efd;

    box-shadow:
        0 5px 15px
        rgba(13, 110, 253, .25);

}


/* =========================================================
   SELECTED YEAR
========================================================= */

.selected-year {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 18px 22px;

    background: #fff;

    border-radius: 14px;

    box-shadow:
        0 4px 15px rgba(0, 0, 0, .04);

}


.selected-year-label {

    display: block;

    color: #8a8f98;

    font-size: 12px;

    margin-bottom: 3px;

}


.subject-count {

    padding: 7px 13px;

    border-radius: 50px;

    background:
        rgba(13, 110, 253, .08);

    color: #0d6efd;

    font-size: 13px;

    font-weight: 700;

}


/* =========================================================
   SUBJECT CARD
========================================================= */

.subject-card {

    overflow: hidden;

    background: #fff;

    border-radius: 18px;

    border: 1px solid rgba(0, 0, 0, .05);

    box-shadow:
        0 5px 20px rgba(0, 0, 0, .05);

    transition:
        transform .3s ease,
        box-shadow .3s ease;

}


.subject-card:hover {

    transform: translateY(-7px);

    box-shadow:
        0 15px 35px rgba(0, 0, 0, .12);

}


/* =========================================================
   IMAGE
========================================================= */

.subject-image {

    position: relative;

    height: 210px;

    overflow: hidden;

    background: #f1f3f5;

}


.subject-image img {

    width: 100%;

    height: 100%;

    display: block;

    object-fit: cover;

    transition:
        transform .4s ease;

}


.subject-card:hover .subject-image img {

    transform: scale(1.05);

}


/* =========================================================
   YEAR BADGE
========================================================= */

.year-badge {

    position: absolute;

    top: 15px;

    right: 15px;

    padding: 7px 14px;

    border-radius: 50px;

    background: #0d6efd;

    color: #fff;

    font-size: 12px;

    font-weight: 700;

}


/* =========================================================
   CONTENT
========================================================= */

.subject-content {

    padding: 24px;

}


.subject-code {

    margin-bottom: 8px;

    color: #0d6efd;

    font-size: 13px;

    font-weight: 700;

    letter-spacing: .5px;

}


.subject-title {

    min-height: 57px;

    margin-bottom: 15px;

    color: #212529;

    font-size: 19px;

    font-weight: 700;

    line-height: 1.5;

}


.subject-line {

    height: 1px;

    margin-bottom: 18px;

    background: #e9ecef;

}


/* =========================================================
   DETAILS
========================================================= */

.subject-info {

    display: flex;

    flex-direction: column;

    gap: 13px;

}


.info-item {

    display: flex;

    align-items: center;

    gap: 10px;

}


.info-icon {

    width: 34px;

    height: 34px;

    min-width: 34px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    background:
        rgba(13, 110, 253, .08);

    color: #0d6efd;

}


.info-item small {

    display: block;

    margin-bottom: 2px;

    color: #8a8f98;

    font-size: 11px;

}


.info-item strong {

    display: block;

    color: #343a40;

    font-size: 14px;

}


/* =========================================================
   EMPTY
========================================================= */

.empty-subject {

    max-width: 450px;

    margin: 30px auto;

    padding: 50px 30px;

    text-align: center;

    background: #fff;

    border-radius: 18px;

    box-shadow:
        0 5px 20px rgba(0, 0, 0, .05);

}


.empty-icon {

    width: 75px;

    height: 75px;

    margin: auto;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #f1f3f5;

    color: #adb5bd;

    font-size: 32px;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 576px) {

    .year-filter {

        border-radius: 18px;

    }

    .year-filter-btn {

        min-width: 80px;

        padding: 9px 14px;

    }

    .selected-year {

        align-items: flex-start;

        flex-direction: column;

    }

    .subject-image {

        height: 200px;

    }

}

</style>

@endsection
