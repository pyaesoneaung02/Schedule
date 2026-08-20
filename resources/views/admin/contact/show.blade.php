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

            View contact message and manage reply/status.

        </p>

    </div>


    {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}
    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="mr-2 fa-solid fa-circle-check"></i>

            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif


    {{-- =========================================================
        CONTACT DETAILS CARD
    ========================================================== --}}
    <div class="border-0 shadow-sm card">


        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="text-white card-header bg-primary">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="mr-2 fa-solid fa-envelope-open-text"></i>

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
            TABLE
        ====================================================== --}}
        <div class="p-0 card-body">

            <div class="table-responsive">

                <table class="table mb-0 table-bordered">

                    <tbody>


                        {{-- NAME --}}
                        <tr>

                            <th class="bg-light"
                                style="width:220px;">

                                <i class="mr-2 fa-solid fa-user text-primary"></i>

                                Name

                            </th>

                            <td>

                                {{ $contact->teacher?->name
                                    ?? $contact->user?->name
                                    ?? $contact->name
                                    ?? 'N/A' }}

                            </td>

                        </tr>


                        {{-- EMAIL --}}
                        <tr>

                            <th class="bg-light">

                                <i class="mr-2 fa-solid fa-envelope text-primary"></i>

                                Email

                            </th>

                            <td>

                                @php

                                    $email =
                                        $contact->email
                                        ?? $contact->user?->email
                                        ?? $contact->teacher?->user?->email;

                                @endphp


                                @if ($email)

                                    <a href="mailto:{{ $email }}">

                                        {{ $email }}

                                    </a>

                                @else

                                    N/A

                                @endif

                            </td>

                        </tr>


                        {{-- PHONE --}}
                        <tr>

                            <th class="bg-light">

                                <i class="mr-2 fa-solid fa-phone text-primary"></i>

                                Phone

                            </th>

                            <td>

                                @php

                                    $phone =
                                        $contact->user?->phone
                                        ?? $contact->teacher?->user?->phone;

                                @endphp


                                @if ($phone)

                                    <a href="tel:{{ $phone }}">

                                        {{ $phone }}

                                    </a>

                                @else

                                    N/A

                                @endif

                            </td>

                        </tr>


                        {{-- DEPARTMENT --}}
                        <tr>

                            <th class="bg-light">

                                <i class="mr-2 fa-solid fa-building text-primary"></i>

                                Department

                            </th>

                            <td>

                                {{ $contact->department ?? 'N/A' }}

                            </td>

                        </tr>


                        {{-- SUBJECT --}}
                        <tr>

                            <th class="bg-light">

                                <i class="mr-2 fa-solid fa-heading text-primary"></i>

                                Subject

                            </th>

                            <td>

                                <strong>

                                    {{ $contact->subject ?? 'No Subject' }}

                                </strong>

                            </td>

                        </tr>


                        {{-- STATUS --}}
                        <tr>

                            <th class="bg-light">

                                <i class="mr-2 fa-solid fa-circle-info text-primary"></i>

                                Status

                            </th>

                            <td>

                                @if ($contact->status === 'pending')

                                    <span class="badge badge-warning">

                                        <i class="mr-1 fa-solid fa-clock"></i>

                                        Pending

                                    </span>

                                @elseif ($contact->status === 'accepted')

                                    <span class="badge badge-success">

                                        <i class="mr-1 fa-solid fa-check"></i>

                                        Accepted

                                    </span>

                                @elseif ($contact->status === 'rejected')

                                    <span class="badge badge-danger">

                                        <i class="mr-1 fa-solid fa-xmark"></i>

                                        Rejected

                                    </span>

                                @endif

                            </td>

                        </tr>


                        {{-- SENT DATE --}}
                        <tr>

                            <th class="bg-light">

                                <i class="mr-2 fa-solid fa-calendar text-primary"></i>

                                Sent Date

                            </th>

                            <td>

                                {{ $contact->created_at
                                    ? $contact->created_at->format('d M Y, h:i A')
                                    : 'N/A' }}

                            </td>

                        </tr>


                        {{-- UPDATED DATE --}}
                        <tr>

                            <th class="bg-light">

                                <i class="mr-2 fa-solid fa-clock text-primary"></i>

                                Last Updated

                            </th>

                            <td>

                                {{ $contact->updated_at
                                    ? $contact->updated_at->format('d M Y, h:i A')
                                    : 'N/A' }}

                            </td>

                        </tr>


                        {{-- MESSAGE --}}
                        <tr>

                            <th class="align-top bg-light">

                                <i class="mr-2 fa-solid fa-message text-primary"></i>

                                Message

                            </th>

                            <td>

                                <div class="p-3 border rounded bg-light"
                                     style="
                                        min-height:120px;
                                        white-space:pre-line;
                                     ">

                                    {{ $contact->message ?? 'No message available.' }}

                                </div>

                            </td>

                        </tr>


                        {{-- ADMIN REPLY --}}
                        <tr>

                            <th class="align-top bg-light">

                                <i class="mr-2 fa-solid fa-reply text-success"></i>

                                Admin Reply

                            </th>

                            <td>

                                @if ($contact->reply_message)

                                    <div class="p-3 border rounded"
                                         style="
                                            background:#f0fff4;
                                            min-height:100px;
                                            white-space:pre-line;
                                         ">

                                        {{ $contact->reply_message }}

                                    </div>

                                @else

                                    <span class="text-muted">

                                        <i class="mr-1 fa-solid fa-circle-info"></i>

                                        No reply has been sent yet.

                                    </span>

                                @endif

                            </td>

                        </tr>


                    </tbody>

                </table>

            </div>


            {{-- =================================================
                ACTION BUTTONS
            ================================================== --}}
            <div class="p-4 border-top">

                <div class="flex-wrap d-flex justify-content-between align-items-center">


                    {{-- BACK --}}
                    <div class="mb-2">

                        <a href="{{ route('contact.list') }}"
                           class="btn btn-secondary">

                            <i class="mr-1 fa-solid fa-arrow-left"></i>

                            Back to Contact List

                        </a>

                    </div>


                    {{-- ACTIONS --}}
                    <div class="mb-2">


                        {{-- REPLY --}}
                        <a href="{{ route('contact.reply', $contact->id) }}"
                           class="btn btn-primary">

                            <i class="mr-1 fa-solid fa-reply"></i>

                            @if ($contact->reply_message)

                                Edit Reply

                            @else

                                Reply

                            @endif

                        </a>


                        {{-- ACCEPT --}}
                        @if ($contact->status === 'pending')

                            <form action="{{ route('contact.accept', $contact->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('PUT')

                                <button type="submit"
                                        class="btn btn-success"
                                        onclick="return confirm('Accept this contact message?')">

                                    <i class="mr-1 fa-solid fa-check"></i>

                                    Accept

                                </button>

                            </form>


                            {{-- REJECT --}}
                            <form action="{{ route('contact.reject', $contact->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('PUT')

                                <button type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm('Reject this contact message?')">

                                    <i class="mr-1 fa-solid fa-xmark"></i>

                                    Reject

                                </button>

                            </form>


                        @elseif ($contact->status === 'accepted')

                            {{-- CHANGE TO REJECT --}}
                            <form action="{{ route('contact.reject', $contact->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('PUT')

                                <button type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm('Change status to Rejected?')">

                                    <i class="mr-1 fa-solid fa-xmark"></i>

                                    Reject

                                </button>

                            </form>


                        @elseif ($contact->status === 'rejected')

                            {{-- CHANGE TO ACCEPT --}}
                            <form action="{{ route('contact.accept', $contact->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('PUT')

                                <button type="submit"
                                        class="btn btn-success"
                                        onclick="return confirm('Change status to Accepted?')">

                                    <i class="mr-1 fa-solid fa-check"></i>

                                    Accept

                                </button>

                            </form>

                        @endif


                        {{-- DELETE --}}
                        <form action="{{ route('contact.delete', $contact->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this contact message?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-outline-danger">

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
