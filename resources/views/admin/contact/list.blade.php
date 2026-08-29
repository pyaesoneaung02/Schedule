@extends('admin.layouts.master')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <style>
        /* =====================================================
            CONTACT PAGE
        ===================================================== */

        .contact-page {
            padding-bottom: 30px;
        }

        /* Header */
        .contact-header {
            margin-bottom: 25px;
        }

        .contact-title {
            font-size: 24px;
            font-weight: 800;
            color: #000000 !important;
            margin-bottom: 5px;
        }

        .contact-title i {
            color: #4e73df;
        }

        .contact-subtitle {
            color: #000000 !important;
            font-weight: 700;
            font-size: 13px;
            margin: 0;
        }

        /* Search */
        .contact-search {
            width: 320px;
        }

        .contact-search .form-control {
            height: 42px;
            border: 1px solid #dfe3e8;
            border-right: 0;
            border-radius: 8px 0 0 8px;
            font-size: 13px;
            box-shadow: none;
            color: #000000 !important;
            font-weight: 700;
        }

        .contact-search .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, .08);
        }

        .contact-search .btn {
            width: 48px;
            border-radius: 0 8px 8px 0;
        }

        /* Main Card */
        .contact-card {
            border: 0;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 5px 25px rgba(58, 59, 69, .08);
        }

        .contact-card-header {
            padding: 18px 22px;
            background: linear-gradient(135deg,
                    #4e73df,
                    #224abe);
            color: #fff;
        }

        .contact-card-header h5 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
        }

        .contact-card-header i {
            margin-right: 8px;
        }

        .contact-card-body {
            padding: 0;
        }

        /* Table */
        .contact-table {
            margin: 0;
            border: 0 !important;
        }

        .contact-table thead th {
            background: #f8f9fc;
            color: #000000 !important;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-top: 0;
            border-bottom: 1px solid #e3e6f0;
            padding: 15px 14px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .contact-table tbody td {
            padding: 15px 14px;
            font-size: 13px;
            color: #000000 !important;
            font-weight: 700;
            border-color: #edf0f5;
            vertical-align: middle;
        }

        .contact-table tbody tr {
            transition: all .2s ease;
        }

        .contact-table tbody tr:hover {
            background: #f8faff;
        }

        /* Teacher */
        .teacher-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .teacher-avatar {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg,
                    #4e73df,
                    #224abe);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
        }

        .teacher-name {
            color: #000000 !important;
            font-weight: 700;
            font-size: 13px;
        }

        /* Email */
        .email-text {
            color: #000000 !important;
            font-weight: 700;
            font-size: 12px;
        }

        /* Phone */
        .phone-text {
            white-space: nowrap;
            color: #000000 !important;
            font-weight: 700;
        }

        /* Message */
        .message-preview {
            max-width: 250px;
            line-height: 1.5;
            color: #000000 !important;
            font-weight: 700;
        }

        /* Status */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-pending {
            color: #856404;
            background: #fff3cd;
        }

        .status-accepted {
            color: #155724;
            background: #d4edda;
        }

        .status-rejected {
            color: #721c24;
            background: #f8d7da;
        }

        .status-default {
            color: #495057;
            background: #e9ecef;
        }

        /* Date */
        .date-text {
            white-space: nowrap;
            font-size: 12px;
            color: #000000 !important;
            font-weight: 700;
        }

        /* Actions */
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px !important;
            font-size: 12px;
            transition: all .2s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        /* Empty */
        .empty-state {
            padding: 70px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: #f1f4f9;
            color: #b7becb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .empty-state h5 {
            color: #000000 !important;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .empty-state p {
            color: #000000 !important;
            font-weight: 700;
            font-size: 13px;
            margin: 0;
        }

        /* Pagination */
        .contact-pagination {
            padding: 18px 22px;
            border-top: 1px solid #edf0f5;
            background: #fff;
        }

        .contact-pagination nav {
            margin: 0;
        }

        .contact-pagination .pagination {
            margin-bottom: 0;
        }

        /* Responsive */
        @media(max-width: 991px) {

            .contact-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 15px;
            }

            .contact-search {
                width: 100%;
            }

            .message-preview {
                max-width: 180px;
            }
        }

        @media(max-width: 576px) {

            .contact-title {
                font-size: 20px;
            }

            .contact-card-header {
                padding: 15px;
            }

            .contact-table thead th,
            .contact-table tbody td {
                padding: 12px 10px;
            }

            .teacher-avatar {
                width: 32px;
                height: 32px;
                min-width: 32px;
            }

            .action-btn {
                width: 32px;
                height: 32px;
            }

        }
    </style>


    <div class="container-fluid contact-page">

        {{-- =====================================================
          PAGE HEADER
    ====================================================== --}}

        <div class="contact-header d-flex justify-content-between align-items-center">

            {{-- Title --}}
            <div>

                <h2 class="contact-title font-weight-bold" style="color: #000 !important;">

                    <i class="mr-2 fa-solid fa-envelope-open-text text-primary"></i>

                    Contact Messages

                </h2>

                <p class="contact-subtitle font-weight-bold" style="color: #000 !important;">

                    Manage and respond to messages from teachers.

                </p>

            </div>


            {{-- Search --}}
            <form action="{{ route('contact.list') }}" method="GET" class="contact-search">

                <div class="input-group">

                    <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control font-weight-bold"
                        placeholder="Search teacher, email or message..." style="color: #000 !important;">

                    <button type="submit" class="btn btn-primary font-weight-bold">

                        <i class="fa-solid fa-magnifying-glass"></i>

                    </button>

                </div>

            </form>

        </div>



        {{-- =====================================================
         CONTACT CARD
    ====================================================== --}}

        <div class="contact-card">


            {{-- Card Header --}}
            <div class="contact-card-header">

                <h5 class="font-weight-bold">

                    <i class="fa-solid fa-inbox"></i>

                    Contact Messages

                </h5>

            </div>



            {{-- Card Body --}}
            <div class="contact-card-body">

                <div class="table-responsive">

                    <table class="table contact-table">

                        {{-- =================================================
                        TABLE HEADER
                    ================================================== --}}

                        <thead>

                            <tr class="font-weight-bold" style="color: #000 !important;">

                                <th style="color: #000 !important;">
                                    Teacher
                                </th>

                                <th style="color: #000 !important;">
                                    Email
                                </th>

                                <th style="color: #000 !important;">
                                    Phone
                                </th>

                                <th style="color: #000 !important;">
                                    Message
                                </th>

                                <th class="text-center" style="color: #000 !important;">
                                    Status
                                </th>

                                <th style="color: #000 !important;">
                                    Date
                                </th>

                                <th class="text-center" style="color: #000 !important;">
                                    Actions
                                </th>

                            </tr>

                        </thead>



                        {{-- =================================================
                        TABLE BODY
                    ================================================== --}}

                        <tbody>

                            @forelse ($contacts as $contact)
                                <tr class="font-weight-bold" style="color: #000 !important;">


                                    {{-- =====================================
                                    TEACHER
                                ====================================== --}}

                                    <td>

                                        <div class="teacher-info">

                                            <div class="teacher-avatar">

                                                {{ strtoupper(substr($contact->teacher?->name ?? ($contact->name ?? 'U'), 0, 1)) }}

                                            </div>


                                            <div>

                                                <div class="teacher-name font-weight-bold" style="color: #000 !important;">

                                                    {{ $contact->teacher?->name ?? ($contact->name ?? 'Unknown') }}

                                                </div>

                                            </div>

                                        </div>

                                    </td>



                                    {{-- =====================================
                                    EMAIL
                                ====================================== --}}

                                    <td>

                                        <span class="email-text font-weight-bold" style="color: #000 !important;">

                                            {{ $contact->teacher?->email ?? ($contact->email ?? 'Unknown') }}

                                        </span>

                                    </td>



                                    {{-- =====================================
                                    PHONE
                                ====================================== --}}

                                    <td>

                                        <span class="phone-text font-weight-bold" style="color: #000 !important;">

                                            {{ $contact->teacher?->user?->phone ?? '09-xxxxxxxxx' }}

                                        </span>

                                    </td>



                                    {{-- =====================================
                                    MESSAGE
                                ====================================== --}}

                                    <td>

                                        <div class="message-preview font-weight-bold" title="{{ $contact->message }}" style="color: #000 !important;">

                                            {{ Str::limit($contact->message, 80) }}

                                        </div>

                                    </td>



                                    {{-- =====================================
                                    STATUS
                                ====================================== --}}

                                    <td class="text-center">

                                        @if ($contact->status === 'pending')
                                            <span class="status-badge status-pending font-weight-bold">

                                                <i class="fa-solid fa-clock"></i>

                                                Pending

                                            </span>
                                        @elseif ($contact->status === 'accepted')
                                            <span class="status-badge status-accepted font-weight-bold">

                                                <i class="fa-solid fa-check"></i>

                                                Accepted

                                            </span>
                                        @elseif ($contact->status === 'rejected')
                                            <span class="status-badge status-rejected font-weight-bold">

                                                <i class="fa-solid fa-xmark"></i>

                                                Rejected

                                            </span>
                                        @else
                                            <span class="status-badge status-default font-weight-bold">

                                                {{ ucfirst($contact->status) }}

                                            </span>
                                        @endif

                                    </td>



                                    {{-- =====================================
                                    DATE
                                ====================================== --}}

                                    <td>

                                        <span class="date-text font-weight-bold" style="color: #000 !important;">

                                            <i class="mr-1 fa-regular fa-calendar"></i>

                                            {{ $contact->created_at->format('d M Y') }}

                                            <br>

                                            <small class="font-weight-bold" style="color: #000 !important;">

                                                {{ $contact->created_at->format('h:i A') }}

                                            </small>

                                        </span>

                                    </td>



                                    {{-- =====================================
                                    ACTIONS
                                ====================================== --}}

                                    <td>

                                        <div class="action-buttons">


                                            {{-- =============================
                                            ACCEPT
                                        ============================== --}}

                                            @if ($contact->status === 'pending')
                                                <form action="{{ route('contact.accept', $contact->id) }}" method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="btn btn-outline-success action-btn font-weight-bold"
                                                        title="Accept"
                                                        onclick="return confirm('Accept this contact message?')">

                                                        <i class="fa-solid fa-check"></i>

                                                    </button>

                                                </form>



                                                {{-- =============================
                                                REJECT
                                            ============================== --}}

                                                <form action="{{ route('contact.reject', $contact->id) }}" method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="btn btn-outline-danger action-btn font-weight-bold"
                                                        title="Reject"
                                                        onclick="return confirm('Reject this contact message?')">

                                                        <i class="fa-solid fa-xmark"></i>

                                                    </button>

                                                </form>
                                            @elseif ($contact->status === 'accepted')
                                                {{-- Change Accepted -> Rejected --}}

                                                <form action="{{ route('contact.reject', $contact->id) }}" method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="btn btn-outline-danger action-btn font-weight-bold"
                                                        title="Reject"
                                                        onclick="return confirm('Change status from Accepted to Rejected?')">

                                                        <i class="fa-solid fa-xmark"></i>

                                                    </button>

                                                </form>
                                            @elseif ($contact->status === 'rejected')
                                                {{-- Change Rejected -> Accepted --}}

                                                <form action="{{ route('contact.accept', $contact->id) }}" method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="btn btn-outline-success action-btn font-weight-bold"
                                                        title="Accept"
                                                        onclick="return confirm('Change status from Rejected to Accepted?')">

                                                        <i class="fa-solid fa-check"></i>

                                                    </button>

                                                </form>
                                            @endif



                                            {{-- =============================
                                            VIEW
                                        ============================== --}}

                                            <a href="{{ route('contact.show', $contact->id) }}"
                                                class="btn btn-outline-primary action-btn font-weight-bold" title="View Message">

                                                <i class="fa-regular fa-eye"></i>

                                            </a>



                                            {{-- =============================
                                            DELETE
                                        ============================== --}}

                                            <form action="{{ route('contact.delete', $contact->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this message?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-danger action-btn font-weight-bold"
                                                    title="Delete">

                                                    <i class="fa-solid fa-trash"></i>

                                                </button>

                                            </form>


                                        </div>

                                    </td>


                                </tr>


                            @empty

                                {{-- =================================================
                                EMPTY STATE
                            ================================================== --}}

                                <tr>

                                    <td colspan="7">

                                        <div class="empty-state">

                                            <div class="empty-icon">

                                                <i class="fa-regular fa-folder-open"></i>

                                            </div>

                                            <h5 class="font-weight-bold" style="color: #000 !important;">

                                                No Contact Messages Found

                                            </h5>

                                            <p class="font-weight-bold" style="color: #000 !important;">

                                                There are no messages to display.

                                            </p>

                                        </div>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>



                {{-- =====================================================
                 PAGINATION
            ====================================================== --}}

                @if ($contacts->hasPages())
                    <div class="contact-pagination">

                        {{ $contacts->withQueryString()->links() }}

                    </div>
                @endif


            </div>

        </div>

    </div>
@endsection