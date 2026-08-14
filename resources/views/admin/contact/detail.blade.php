@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">

            <h2 class="text-primary font-weight-bold">
                <i class="mr-2 fa-solid fa-envelope-open-text"></i>
                Contact Details
            </h2>

            <p class="mb-0 text-muted">
                View contact message details.
            </p>

        </div>


        <!-- Contact Details Card -->
        <div class="border-0 shadow-sm card">

            <!-- Card Header -->
            <div class="text-white card-header bg-primary">

                <div class="d-flex justify-content-between align-items-center">

                    {{-- <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-comment"></i>
                        Contact Message #{{ $contact->id }}
                    </h5> --}}

                    <h5 class="mb-0">
                        <i class="mr-2 fa-solid fa-comment"></i>
                        Contact Message
                    </h5>

                    <!-- Status -->
                    @if ($contact->status === 'pending')
                        <span class="badge badge-warning">
                            Pending
                        </span>
                    @elseif ($contact->status === 'accepted')
                        <span class="badge badge-success">
                            Accepted
                        </span>
                    @elseif ($contact->status === 'rejected')
                        <span class="badge badge-danger">
                            Rejected
                        </span>
                    @endif

                </div>

            </div>


            <!-- Card Body -->
            <div class="card-body">

                <!-- Teacher Information -->
                <div class="mb-4">

                    <h5 class="mb-3 text-primary font-weight-bold">
                        <i class="mr-2 fa-solid fa-user-tie"></i>
                        Teacher Information
                    </h5>

                    <div class="row">

                        <!-- Teacher Name -->
                        <div class="mb-3 col-md-6">

                            <div class="p-3 border rounded bg-light">

                                <small class="text-muted d-block">
                                    Teacher Name
                                </small>

                                <strong>
                                    {{ $contact->teacher?->name ?? ($contact->name ?? 'N/A') }}
                                </strong>

                            </div>

                        </div>


                        <!-- Phone -->
                        <div class="mb-3 col-md-6">

                            <div class="p-3 border rounded bg-light">

                                <small class="text-muted d-block">
                                    Phone Number
                                </small>

                                @if ($contact->teacher?->user?->role === 'teacher')
                                    <strong>
                                        <i class="mr-1 fa-solid fa-phone text-success"></i>

                                        {{ $contact->teacher->user->phone ?? 'N/A' }}
                                    </strong>
                                @else
                                    <strong>
                                        N/A
                                    </strong>
                                @endif

                            </div>

                        </div>


                        <!-- Email -->
                        <div class="mb-3 col-md-6">

                            <div class="p-3 border rounded bg-light">

                                <small class="text-muted d-block">
                                    Email
                                </small>

                                <strong>
                                    {{ $contact->email ?? ($contact->teacher?->user?->email ?? 'N/A') }}
                                </strong>

                            </div>

                        </div>


                        <!-- Department -->
                        <div class="mb-3 col-md-6">

                            <div class="p-3 border rounded bg-light">

                                <small class="text-muted d-block">
                                    Department
                                </small>

                                <strong>
                                    {{ $contact->department ?? 'N/A' }}
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                <hr>


                <!-- Contact Information -->
                <div class="my-4">

                    <h5 class="mb-3 text-primary font-weight-bold">
                        <i class="mr-2 fa-solid fa-envelope"></i>
                        Contact Information
                    </h5>

                    <div class="row">

                        <!-- Subject -->
                        <div class="mb-3 col-md-12">

                            <div class="p-3 border rounded bg-light">

                                <small class="text-muted d-block">
                                    Subject
                                </small>

                                <strong>
                                    {{ $contact->subject ?? 'No Subject' }}
                                </strong>

                            </div>

                        </div>


                        <!-- Message -->
                        <div class="mb-3 col-md-12">

                            <div class="p-3 border rounded bg-light">

                                <small class="mb-2 text-muted d-block">
                                    Message
                                </small>

                                <div style="white-space: pre-line;">
                                    {{ $contact->message }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <hr>


                <!-- Actions -->
                <div class="pt-3 mt-4 border-top">

                    <div class="d-flex justify-content-between align-items-center">

                        <!-- Back -->
                        <a href="{{ route('contact.list') }}" class="btn btn-secondary">

                            <i class="mr-1 fa-solid fa-arrow-left"></i>
                            Back to Contact List

                        </a>


                        <!-- Status Actions -->
                        <div>

                            @if ($contact->status === 'pending')
                                <!-- Accept -->
                                <form action="{{ route('contact.accept', $contact->id) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Accept this contact message?')">

                                        <i class="mr-1 fa-solid fa-check"></i>
                                        Accept

                                    </button>

                                </form>


                                <!-- Reject -->
                                <form action="{{ route('contact.reject', $contact->id) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Reject this contact message?')">

                                        <i class="mr-1 fa-solid fa-xmark"></i>
                                        Reject

                                    </button>

                                </form>
                            @elseif ($contact->status === 'accepted')
                                <!-- Change to Rejected -->
                                <form action="{{ route('contact.reject', $contact->id) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Change status to Rejected?')">

                                        <i class="mr-1 fa-solid fa-xmark"></i>
                                        Reject

                                    </button>

                                </form>
                            @elseif ($contact->status === 'rejected')
                                <!-- Change to Accepted -->
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


                            <!-- Delete -->
                            <form action="{{ route('contact.delete', $contact->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Delete this contact message?')">

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
