@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="mb-4">

        <h2 class="text-primary font-weight-bold">

            <i class="mr-2 fa-solid fa-reply"></i>
            Reply to Contact

        </h2>

        <p class="mb-0 text-muted">
            Reply to the contact message.
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
        VALIDATION ERROR
    ========================================================== --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>
                Please check the following errors:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================================
        ORIGINAL MESSAGE
    ========================================================== --}}
    <div class="mb-4 border-0 shadow-sm card">

        <div class="text-white card-header bg-primary">

            <h5 class="mb-0">

                <i class="mr-2 fa-solid fa-envelope"></i>
                Original Contact Message

            </h5>

        </div>


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


                        {{-- MESSAGE --}}
                        <tr>

                            <th class="align-top bg-light">

                                <i class="mr-2 fa-solid fa-message text-primary"></i>

                                Message

                            </th>

                            <td>

                                <div class="p-3 border rounded bg-light"
                                     style="min-height:120px; white-space:pre-line;">

                                    {{ $contact->message }}

                                </div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- =========================================================
        REPLY FORM
    ========================================================== --}}
    <div class="border-0 shadow-sm card">

        <div class="text-white card-header bg-success">

            <h5 class="mb-0">

                <i class="mr-2 fa-solid fa-paper-plane"></i>

                Write Reply

            </h5>

        </div>


        <div class="card-body">

            <form action="{{ route('contact.sendReply', $contact->id) }}"
                  method="POST">

                @csrf


                {{-- REPLY MESSAGE --}}
                <div class="mb-4">

                    <label for="reply_message"
                           class="font-weight-bold">

                        <i class="mr-1 fa-solid fa-comment-dots"></i>

                        Reply Message

                    </label>


                    <textarea
                        name="reply_message"
                        id="reply_message"
                        rows="10"
                        required
                        class="form-control @error('reply_message') is-invalid @enderror"
                        placeholder="Write your reply here..."
                    >{{ old('reply_message', $contact->reply_message) }}</textarea>


                    @error('reply_message')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- =================================================
                    ACTIONS
                ================================================== --}}
                <div class="d-flex justify-content-between align-items-center">

                    {{-- BACK --}}
                    <a href="{{ route('contact.show', $contact->id) }}"
                       class="btn btn-secondary">

                        <i class="mr-1 fa-solid fa-arrow-left"></i>

                        Back

                    </a>


                    {{-- SEND / UPDATE --}}
                    <button type="submit"
                            class="btn btn-success">

                        <i class="mr-1 fa-solid fa-paper-plane"></i>

                        @if ($contact->reply_message)

                            Update Reply

                        @else

                            Send Reply

                        @endif

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
