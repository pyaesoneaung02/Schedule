@extends('admin.layouts.master')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="mb-4 d-flex justify-content-between align-items-center">

            <div>
                <h2 class="text-primary font-weight-bold">
                    <i class="mr-2 fa-solid fa-comment"></i>
                    Contact List
                </h2>

                <p class="mb-0 text-muted">
                    Manage contact messages.
                </p>
            </div>

            {{-- Search --}}
            <div>

                <form action="{{ route('contact.list') }}" method="GET">

                    <div class="input-group">

                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control"
                            placeholder="Search...">

                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- Contact Card --}}
        <div class="border-0 shadow-sm card">

            <!-- Card Header -->
            <div class="text-white card-header bg-primary">

                <h5 class="mb-0">
                    <i class="mr-2 fa-solid fa-comment"></i>
                    Contact Messages
                </h5>

            </div>


            <!-- Card Body -->
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle table-hover table-bordered">

                        {{-- Table Header --}}
                        <thead class="thead-light">

                            <tr class="text-center">

                                {{-- <th width="70">
                                    ID
                                </th> --}}

                                <th>
                                    Teacher Name
                                </th>

                                <th>
                                    Teacher' Email
                                </th>

                                <th>
                                    Phone
                                </th>

                                <th>
                                    Message
                                </th>

                                <th width="130">
                                    Status
                                </th>

                                <th width="180">
                                    Created Date
                                </th>

                                <th width="220">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        {{-- Table Body --}}
                        <tbody>

                            @forelse ($contacts as $contact)
                                <tr>

                                    <!-- ID -->
                                    {{-- <td class="text-center">
                                        {{ $contact->id }}
                                    </td> --}}


                                    <!-- Teacher Name -->
                                    <td>

                                        {{ $contact->teacher?->name ?? ($contact->name ?? 'Unknown') }}

                                    </td>

                                    <!-- Teacher Email -->
                                    <td>

                                        {{ $contact->teacher?->email ?? ($contact->email ?? 'Unknown') }}

                                    </td>

                                    <!-- Phone -->
                                    <td>
                                        {{ $contact->teacher?->user?->phone ?? '09xxxxxxxxx' }}
                                    </td>

                                    <!-- Message -->
                                    <td>

                                        {{ Str::limit($contact->message, 80) }}

                                    </td>


                                    <!-- Status -->
                                    <td class="text-center">

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
                                        @else
                                            <span class="badge badge-secondary">
                                                {{ ucfirst($contact->status) }}
                                            </span>
                                        @endif

                                    </td>


                                    <!-- Created Date -->
                                    <td>

                                        {{ $contact->created_at->format('d M Y, h:i A') }}

                                    </td>

                                    {{-- Action --}}
                                    <td class="text-center">

                                        {{-- PENDING --}}
                                        @if ($contact->status === 'pending')
                                            <!-- Accept -->
                                            <form action="{{ route('contact.accept', $contact->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Accept"
                                                    onclick="return confirm('Accept this contact message?')">

                                                    <i class="fa-solid fa-check"></i>

                                                </button>

                                            </form>


                                            <!-- Reject -->
                                            <form action="{{ route('contact.reject', $contact->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Reject"
                                                    onclick="return confirm('Reject this contact message?')">

                                                    <i class="fa-solid fa-xmark"></i>

                                                </button>

                                            </form>



                                            {{-- ACCEPTED --}}
                                        @elseif ($contact->status === 'accepted')
                                            <form action="{{ route('contact.reject', $contact->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Reject"
                                                    onclick="return confirm('Change status from Accepted to Rejected?')">

                                                    <i class="fa-solid fa-xmark"></i>

                                                </button>

                                            </form>



                                            {{-- REJECTED --}}
                                        @elseif ($contact->status === 'rejected')
                                            <form action="{{ route('contact.accept', $contact->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Accept"
                                                    onclick="return confirm('Change status from Rejected to Accepted?')">

                                                    <i class="fa-solid fa-check"></i>

                                                </button>

                                            </form>
                                        @endif

                                        {{-- View --}}
                                        <a href="{{ route('contact.show', $contact->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="View">

                                            <i class="fa-regular fa-eye"></i>

                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('contact.delete', $contact->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this message?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>


                            @empty

                                <!-- No Data -->
                                <tr>

                                    <td colspan="6" class="py-5 text-center text-muted">

                                        <i class="mb-3 fa-regular fa-folder-open fa-2x d-block"></i>

                                        No contact messages found.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3 d-flex justify-content-end">

                    {{ $contacts->links() }}

                </div>

            </div>

        </div>

    </div>
@endsection
