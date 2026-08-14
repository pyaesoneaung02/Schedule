@extends('user.layouts.master')

@section('content')
    <div class="hero-section hero-style-5 img-bg"
        style="background-image: url('{{ asset('user/img/hero/hero-5/hero-bg.svg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-content-wrapper">
                        <h2 class="mb-30 wow fadeInUp" data-wow-delay=".2s">Welcome to the UCSMGY Teacher Portal</h2>
                        <p class="mb-30 wow fadeInUp" data-wow-delay=".4s">Manage your class schedules across different
                            sections and view assigned subjects at the University of Computer Studies, Magway.</p>
                        <a href="#schedule" class="button button-lg radius-50 wow fadeInUp page-scroll"
                            data-wow-delay=".6s">View Timetable <i class="lni lni-chevron-right"></i> </a>
                    </div>
                </div>
                <div class="col-lg-6 align-self-end">
                    <div class="hero-image wow fadeInUp" data-wow-delay=".5s">
                        <img src="{{ asset('user/img/hero/hero-5/hero-img.svg') }}" alt="UCSM Teacher Dashboard">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
