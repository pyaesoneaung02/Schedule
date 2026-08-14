@extends('user.layouts.master')

@section('content')
    <section id="contact" class="contact-section contact-style-3 pb-100 pt-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-7 col-md-10">
                    <div class="section-title text-center mb-50">
                        <h3 class="mb-15">Contact Administration</h3>
                        <p>Need assistance with your schedule, leave requests, or technical support? Send a message directly
                            to the UCSM admin office.</p>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="lni lni-checkmark-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="text" id="name" name="name" class="form-input"
                                            value="{{ Auth::check() ? Auth::user()->name : '' }}" placeholder="Teacher Name"
                                            required>
                                        <i class="lni lni-user"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="email" id="email" name="email" class="form-input"
                                            value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                            placeholder="UCSM Email (@ucsm.edu.mm)" required>
                                        <i class="lni lni-envelope"></i>
                                    </div>
                                </div>
                                @php
                                    $loggedUser = auth()->user();
                                    $currentTeacher = App\Models\Teacher::with('department')
                                        ->where('user_id', $loggedUser->id)
                                        ->first();
                                @endphp

                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="text" id="department" name="department" class="form-input"
                                            value="{{ $currentTeacher && $currentTeacher->department ? $currentTeacher->department->name : '' }}"
                                            placeholder="Department" readonly required>
                                        <i class="lni lni-apartment"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="text" id="subject" name="subject" class="form-input"
                                            placeholder="Inquiry Subject" required>
                                        <i class="lni lni-text-format"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single-input">
                                        <textarea name="message" id="message" class="form-input" placeholder="Your Message" rows="6" required></textarea>
                                        <i class="lni lni-comments-alt"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-button">
                                        <button type="submit" class="button"> <i class="lni lni-telegram-original"></i>
                                            Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="left-wrapper">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <div class="single-item">
                                    <div class="icon">
                                        <i class="lni lni-phone"></i>
                                    </div>
                                    <div class="text">
                                        <p>Staff Helpline:</p>
                                        <p>+95 9 600 000 999</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="single-item">
                                    <div class="icon">
                                        <i class="lni lni-envelope"></i>
                                    </div>
                                    <div class="text">
                                        <p>Admin Email:</p>
                                        <p>admincumgy@gmail.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="single-item">
                                    <div class="icon">
                                        <i class="lni lni-map-marker"></i>
                                    </div>
                                    <div class="text">
                                        <p>University of Computer Studies,<br>Magway, Myanmar</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
