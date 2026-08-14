@extends('user.layouts.master')

@section('content')
    <section id="subject" class="pricing-section pricing-style-4 bg-light pb-100 pt-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-12">
                    <div class="section-title mb-60">
                        <h3 class="mb-15 wow fadeInUp" data-wow-delay=".2s">Assigned Subjects</h3>

                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <div class="pricing-active-wrapper wow fadeInUp" data-wow-delay=".4s">
                        <div class="pricing-active">
                            @forelse($teachings as $teaching)
                                <!-- Subject -->
                                <div class="single-pricing-wrapper">
                                    <div class="single-pricing">
                                        <h6>{{ $teaching->year->name ?? 'Year' }}</h6>
                                        <h4>{{ $teaching->major->name ?? 'Major' }}
                                            ({{ $teaching->section->name ?? 'Section' }})</h4>
                                        <hr>
                                        <ul class="text-start mt-4 mb-4 list-unstyled">
                                            <li class="mb-2"><i class="lni lni-book me-2 text-primary"></i>
                                                <strong>Subject:</strong> {{ $teaching->subject->long_name ?? 'N/A' }}</li>
                                            <li class="mb-2"><i class="lni lni-map-marker me-2 text-primary"></i>
                                                <strong>Room:</strong> {{ $teaching->room->name ?? 'N/A' }}</li>
                                            <li class="mb-2"><i class="lni lni-calendar me-2 text-primary"></i>
                                                <strong>Semester:</strong> {{ $teaching->semester->name ?? 'N/A' }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <div class="w-100 text-center py-4 bg-white rounded-3 shadow-sm">
                                    <p class="text-muted mb-0">No assigned subjects found.</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
