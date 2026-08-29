@extends('user.layouts.master')

@section('content')
    <style>
        /* =========================================
           PAGE
        ========================================= */

        .notification-page {
            padding-top: 35px;
            padding-bottom: 55px;
        }


        /* =========================================
           HEADER
        ========================================= */

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .notification-title {
            margin: 0;
            color: #111827;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.4px;
        }

        .notification-subtitle {
            margin: 6px 0 0;
            color: #5f6877;
            font-size: 13px;
            font-weight: 500;
        }


        /* =========================================
           CARD
        ========================================= */

        .notification-card {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 8px 30px rgba(17, 24, 39, .08);
        }

        .notification-card .card-body {
            padding: 0;
        }


        /* =========================================
           TABLE
        ========================================= */

        .notification-table {
            margin-bottom: 0;
            color: #212529;
        }


        /* TABLE HEADER */

        .notification-table thead th {
            background: #f5f7fa;
            color: #1f2937;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 17px 18px;
            border-bottom: 1px solid #dfe3e8;
            white-space: nowrap;
        }


        /* TABLE BODY */

        .notification-table tbody td {
            padding: 18px;
            border-color: #e9edf2;
            color: #303844;
            font-size: 13px;
            font-weight: 500;
            vertical-align: middle;
        }


        /* ROW HOVER */

        .notification-table tbody tr {
            transition: all .2s ease;
        }

        .notification-table tbody tr:hover {
            background: #fafbfc;
        }


        /* =========================================
           SUBJECT
        ========================================= */

        .subject-text {
            color: #111827;
            font-size: 13px;
            font-weight: 750;
            line-height: 1.5;
        }


        /* =========================================
           MESSAGE
        ========================================= */

        .message-text {
            max-width: 230px;
            color: #343a40;
            font-size: 13px;
            font-weight: 550;
            line-height: 1.5;
        }


        /* =========================================
           REPLY
        ========================================= */

        .reply-text {
            max-width: 260px;
            color: #343a40;
            font-size: 13px;
            font-weight: 550;
            line-height: 1.5;
        }

        .reply-empty {
            display: inline-flex;
            align-items: center;
            color: #000000;
            font-size: 13px;
            font-weight: 500;
            font-style: italic;
            white-space: nowrap;
        }

        .reply-empty i {
            font-size: 13px;
        }


        /* =========================================
           STATUS
        ========================================= */

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
        }


        /* =========================================
           DATE
        ========================================= */

        .date-text {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            color: #343a40;
            font-size: 12px;
            font-weight: 600;
        }

        .date-text i {
            color: #59636f;
            font-size: 12px;
        }


        /* =========================================
           DELETE BUTTON
        ========================================= */

        .delete-btn {
            width: 36px;
            height: 36px;
            padding: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            color: #dc3545;
            border-color: #dc3545;

            transition: all .2s ease;
        }

        .delete-btn i {
            font-size: 14px;
        }

        .delete-btn:hover {
            color: #ffffff;
            background: #dc3545;
            border-color: #dc3545;
            transform: translateY(-1px);
            box-shadow: 0 5px 12px rgba(220, 53, 69, .18);
        }


        /* =========================================
           EMPTY STATE
        ========================================= */

        .empty-state {
            padding: 65px 20px !important;
            color: #495057 !important;
        }

        .empty-icon {
            width: 70px;
            height: 70px;

            margin: 0 auto 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 20px;

            background: #f1f4f8;
            color: #6b7280;

            font-size: 29px;
        }

        .empty-title {
            margin-bottom: 5px;
            color: #252b33;
            font-size: 14px;
            font-weight: 700;
        }

        .empty-text {
            margin: 0;
            color: #697381;
            font-size: 12px;
            font-weight: 500;
        }


        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 768px) {

            .notification-page {
                padding-top: 20px;
                padding-bottom: 35px;
            }

            .notification-title {
                font-size: 21px;
            }

            .notification-subtitle {
                font-size: 12px;
            }

            .notification-table thead th,
            .notification-table tbody td {
                padding: 13px 12px;
            }

            .notification-table tbody td {
                font-size: 12px;
            }

            .message-text,
            .reply-text {
                max-width: 180px;
            }

            .date-text {
                font-size: 11px;
            }

        }


        @media (max-width: 576px) {

            .notification-header {
                margin-bottom: 18px;
            }

            .notification-title {
                font-size: 19px;
            }

            .notification-subtitle {
                font-size: 11px;
            }

            .notification-card {
                border-radius: 14px;
            }

            .delete-btn {
                width: 32px;
                height: 32px;
            }

        }
    </style>

    <div class="container notification-page">

        <div class="row">

            <div class="mx-auto col-lg-11">


                {{-- =========================================
             PAGE HEADER
        ========================================== --}}

                <div class="notification-header">

                    <div>

                        <h3 class="notification-title">
                            Message Notifications
                        </h3>

                        <p class="notification-subtitle">
                            View your messages, replies and notification status.
                        </p>

                    </div>

                </div>


                {{-- =========================================
             NOTIFICATION CARD
        ========================================== --}}

                <div class="card notification-card pb">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table align-middle notification-table">

                                {{-- =========================================
                             TABLE HEADER
                        ========================================== --}}

                                <thead>

                                    <tr>

                                        <th>
                                            Subject
                                        </th>

                                        <th>
                                            Message
                                        </th>

                                        <th>
                                            Reply Message
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Date
                                        </th>

                                        <th class="text-center">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                {{-- =========================================
                             TABLE BODY
                        ========================================== --}}

                                <tbody>

                                    @forelse($notifications as $item)
                                        <tr>


                                            {{-- SUBJECT --}}
                                            <td>

                                                <span class="subject-text">

                                                    {{ $item->subject ?? 'N/A' }}

                                                </span>

                                            </td>


                                            {{-- MESSAGE --}}
                                            <td>

                                                <div class="message-text">

                                                    {{ Str::limit($item->message ?? '', 40) }}

                                                </div>

                                            </td>


                                            {{-- REPLY --}}
                                            <td>

                                                @if (!empty($item->reply_message))
                                                    <div class="reply-text">

                                                        {{ Str::limit($item->reply_message, 80) }}

                                                    </div>
                                                @else
                                                    <span class="reply-empty" style="color: #000000">

                                                        <i class="bi bi-chat-left-dots me-1"></i>

                                                        No reply has been received yet.

                                                    </span>
                                                @endif

                                            </td>


                                            {{-- STATUS --}}
                                            <td>

                                                @if ($item->status === 'pending')
                                                    <span class="badge bg-warning text-dark status-badge">

                                                        <i class="bi bi-clock"></i>

                                                        Sending

                                                    </span>
                                                @elseif ($item->status === 'accepted')
                                                    <span class="badge bg-success status-badge">

                                                        <i class="bi bi-check-circle"></i>

                                                        Accepted

                                                    </span>
                                                @elseif ($item->status === 'rejected')
                                                    <span class="badge bg-danger status-badge">

                                                        <i class="bi bi-x-circle"></i>

                                                        Rejected

                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary status-badge">

                                                        {{ ucfirst($item->status ?? 'Unknown') }}

                                                    </span>
                                                @endif

                                            </td>


                                            {{-- DATE --}}
                                            <td>

                                                <span class="date-text">

                                                    <i class="bi bi-calendar3 me-1"></i>

                                                    {{ $item->created_at ? $item->created_at->format('d M Y, h:i A') : 'N/A' }}

                                                </span>

                                            </td>


                                            {{-- DELETE --}}
                                            <td class="text-center">

                                                <a href="{{ route('notification.delete', $item->id) }}"
                                                    class="btn btn-sm btn-outline-danger delete-btn delete-notification"
                                                    title="Delete">

                                                    <i class="fa-solid fa-trash"></i>

                                                </a>

                                            </td>


                                        </tr>

                                    @empty


                                        {{-- EMPTY STATE --}}
                                        <tr>

                                            <td colspan="6" class="text-center empty-state">

                                                <div class="empty-icon">

                                                    <i class="bi bi-inbox"></i>

                                                </div>

                                                <div class="empty-title">

                                                    No Messages Yet

                                                </div>

                                                <p class="empty-text">

                                                    You don't have any notifications at the moment.

                                                </p>

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        ```

    </div>

    {{-- =========================================
SWEETALERT
========================================== --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const deleteButtons =
                document.querySelectorAll('.delete-notification');


            deleteButtons.forEach(function(button) {

                button.addEventListener('click', function(event) {

                    event.preventDefault();

                    const deleteUrl =
                        this.getAttribute('href');


                    Swal.fire({

                        title: 'Delete Message?',

                        text: 'This message will be permanently deleted.',

                        icon: 'warning',

                        showCancelButton: true,

                        confirmButtonText: 'Delete',

                        cancelButtonText: 'Cancel',

                        confirmButtonColor: '#dc3545',

                        cancelButtonColor: '#6c757d',

                        reverseButtons: true,

                        allowOutsideClick: false,

                        allowEscapeKey: true

                    }).then(function(result) {

                        if (result.isConfirmed) {

                            window.location.href = deleteUrl;

                        }

                    });

                });

            });

        });
    </script>

    {{-- =========================================
SUCCESS ALERT
========================================== --}}

    @if (session('success'))
        <script>
            Swal.fire({

                icon: 'success',

                title: 'Deleted Successfully',

                text: @json(session('success')),

                confirmButtonText: 'OK',

                confirmButtonColor: '#198754',

                showConfirmButton: true,

                allowOutsideClick: false,

                allowEscapeKey: true

            });
        </script>
    @endif
@endsection
