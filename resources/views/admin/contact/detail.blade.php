@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        {{-- =========================================================
            PAGE HEADER
        ========================================================== --}}
        <div class="mb-4">

            <h2 class="text-primary font-weight-bold">
                <i class="mr-2 fa-solid fa-envelope-open-text"></i>
                Contact Details
            </h2>

            <p class="mb-0 text-muted">
                View and manage contact message details.
            </p>

        </div>


        {{-- =========================================================
            CONTACT DETAILS CARD
        ========================================================== --}}
        <div class="border-0 shadow-sm card">

            {{-- =====================================================
                CARD HEADER
            ====================================================== --}}
            <div class="text-white card-header bg-primary">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-comment"></i>
                        Contact Message
                    </h5>


                    {{-- STATUS --}}
                    @if ($contact->status === 'pending')
                        <span class="px-3 py-2 badge badge-warning">
                            <i class="mr-1 fa-solid fa-clock"></i>
                            Pending
                        </span>
                    @elseif ($contact->status === 'accepted')
                        <span class="px-3 py-2 badge badge-success">
                            <i class="mr-1 fa-solid fa-check"></i>
                            Accepted
                        </span>
                    @elseif ($contact->status === 'rejected')
                        <span class="px-3 py-2 badge badge-danger">
                            <i class="mr-1 fa-solid fa-xmark"></i>
                            Rejected
                        </span>
                    @endif

                </div>

            </div>


            {{-- =====================================================
                CARD BODY
            ====================================================== --}}
            <div class="card-body">

                {{-- =================================================
                    TEACHER INFORMATION
                ================================================== --}}
                <div class="mb-4">

                    <h5 class="mb-4 text-primary font-weight-bold">

                        <i class="mr-2 fa-solid fa-user-tie"></i>
                        Teacher Information

                    </h5>


                    <div class="row">

                        {{-- TEACHER NAME --}}
                        <div class="mb-3 col-md-6">

                            <div class="p-3 border rounded bg-light h-100">

                                <small class="mb-1 text-muted d-block">
                                    <i class="mr-1 fa-solid fa-user"></i>
                                    Teacher Name
                                </small>

                                <strong class="text-dark">

                                    {{ $contact->teacher?->name ?? ($contact->name ?? 'N/A') }}

                                </strong>

                            </div>

                        </div>


                        {{-- PHONE NUMBER --}}
                        <div class="mb-3 col-md-6">

                            <div class="p-3 border rounded bg-light h-100">

                                <small class="mb-1 text-muted d-block">
                                    <i class="mr-1 fa-solid fa-phone"></i>
                                    Phone Number
                                </small>

                                <strong class="text-dark">

                                    @if ($contact->teacher?->user)
                                        {{ $contact->teacher->user->phone ?? 'N/A' }}
                                    @else
                                        {{ $contact->phone ?? 'N/A' }}
                                    @endif

                                </strong>

                            </div>

                        </div>


                        {{-- EMAIL --}}
                        <div class="mb-3 col-md-6">

                            <div class="p-3 border rounded bg-light h-100">

                                <small class="mb-1 text-muted d-block">
                                    <i class="mr-1 fa-solid fa-envelope"></i>
                                    Email Address
                                </small>

                                <strong class="text-dark">

                                    {{ $contact->email ?? ($contact->teacher?->user?->email ?? 'N/A') }}

                                </strong>

                            </div>

                        </div>


                        {{-- DEPARTMENT --}}
                        <div class="mb-3 col-md-6">

                            <div class="p-3 border rounded bg-light h-100">

                                <small class="mb-1 text-muted d-block">
                                    <i class="mr-1 fa-solid fa-building"></i>
                                    Department
                                </small>

                                <strong class="text-dark">

                                    {{ $contact->department ?? 'N/A' }}

                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                <hr>


                {{-- =================================================
                    CONTACT INFORMATION
                ================================================== --}}
                <div class="my-4">

                    <h5 class="mb-4 text-primary font-weight-bold">

                        <i class="mr-2 fa-solid fa-envelope"></i>
                        Contact Information

                    </h5>


                    <div class="row">

                        {{-- SUBJECT --}}
                        <div class="mb-3 col-12">

                            <div class="p-3 border rounded bg-light">

                                <small class="mb-1 text-muted d-block">
                                    <i class="mr-1 fa-solid fa-heading"></i>
                                    Subject
                                </small>

                                <strong class="text-dark">

                                    {{ $contact->subject ?? 'No Subject' }}

                                </strong>

                            </div>

                        </div>


                        {{-- MESSAGE --}}
                        <div class="mb-3 col-12">

                            <div class="p-3 border rounded bg-light">

                                <small class="mb-2 text-muted d-block">
                                    <i class="mr-1 fa-solid fa-message"></i>
                                    Message
                                </small>

                                <div class="p-3 bg-white border rounded text-dark"
                                    style="white-space: pre-line; min-height: 120px;">

                                    {{ $contact->message ?? 'No message available.' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <hr>


                {{-- =================================================
                    ACTION BUTTONS
                ================================================== --}}
                <div class="pt-3 mt-4">

                    <div class="flex-wrap d-flex justify-content-between align-items-center">

                        {{-- BACK BUTTON --}}
                        <div class="mb-2">

                            <a href="{{ route('contact.list') }}" class="btn btn-secondary">

                                <i class="mr-1 fa-solid fa-arrow-left"></i>
                                Back to Contact List

                            </a>

                        </div>


                        {{-- ACTION BUTTONS --}}
                        <div class="mb-2">

                            {{-- =====================================
                                REPLY BUTTON
                            ====================================== --}}
                            <a href="{{ route('contact.reply', $contact->id) }}" class="btn btn-primary">

                                <i class="mr-1 fa-solid fa-reply"></i>
                                Reply

                            </a>


                            {{-- =====================================
                                PENDING STATUS
                            ====================================== --}}
                            @if ($contact->status === 'pending')
                                {{-- ACCEPT --}}
                                <form action="{{ route('contact.accept', $contact->id) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Accept this contact message?')">

                                        <i class="mr-1 fa-solid fa-check"></i>
                                        Accept

                                    </button>

                                </form>


                                {{-- REJECT --}}
                                <form action="{{ route('contact.reject', $contact->id) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Reject this contact message?')">

                                        <i class="mr-1 fa-solid fa-xmark"></i>
                                        Reject

                                    </button>

                                </form>


                                {{-- =====================================
                                ACCEPTED STATUS
                            ====================================== --}}
                            @elseif ($contact->status === 'accepted')
                                {{-- CHANGE TO REJECTED --}}
                                <form action="{{ route('contact.reject', $contact->id) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Change status to Rejected?')">

                                        <i class="mr-1 fa-solid fa-xmark"></i>
                                        Reject

                                    </button>

                                </form>


                                {{-- =====================================
                                REJECTED STATUS
                            ====================================== --}}
                            @elseif ($contact->status === 'rejected')
                                {{-- CHANGE TO ACCEPTED --}}
                                <form action="{{ route('contact.accept', $contact->id) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Change status to Accepted?')">

                                        <i class="mr-1 fa-solid fa-check"></i>
                                        Accept

                                    </button>

                                </form>
                            @endif


                            {{-- =====================================
                                DELETE BUTTON
                            ====================================== --}}
                            <form action="{{ route('contact.delete', $contact->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this contact message?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline-danger">

                                    <i class="mr-1 fa-solid fa-trash"></i>
                                    Delete

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
