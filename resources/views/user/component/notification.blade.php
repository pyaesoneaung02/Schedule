@extends('user.layouts.master')

@section('content')

<div class="container mt-5 mb-5">

    <div class="row">

        <div class="col-lg-10 offset-lg-1">

            <h3 class="mb-4">
                Message Notifications & Status
            </h3>


            <div class="border-0 shadow-sm card rounded-3">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table align-middle table-hover">

                            <thead class="table-light">

                                <tr>

                                    <th>Subject</th>

                                    <th>Message</th>

                                    <th>Reply Message</th>

                                    <th>Status</th>

                                    <th>Date</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($notifications as $item)

                                    <tr>

                                        {{-- SUBJECT --}}
                                        <td class="fw-semibold">

                                            {{ $item->subject ?? 'N/A' }}

                                        </td>


                                        {{-- MESSAGE --}}
                                        <td>

                                            {{ Str::limit(
                                                $item->message ?? '',
                                                40
                                            ) }}

                                        </td>


                                        {{-- REPLY --}}
                                        <td>

                                            @if(!empty($item->reply_message))

                                                {{ Str::limit(
                                                    $item->reply_message,
                                                    80
                                                ) }}

                                            @else

                                                <span class="text-muted">
                                                    No reply yet
                                                </span>

                                            @endif

                                        </td>


                                        {{-- STATUS --}}
                                        <td>

                                            @if ($item->status === 'pending')

                                                <span class="badge bg-warning text-dark">

                                                    Pending

                                                </span>

                                            @elseif ($item->status === 'accepted')

                                                <span class="badge bg-success">

                                                    Accepted

                                                </span>

                                            @elseif ($item->status === 'rejected')

                                                <span class="badge bg-danger">

                                                    Rejected

                                                </span>

                                            @else

                                                <span class="badge bg-secondary">

                                                    {{ ucfirst($item->status ?? 'Unknown') }}

                                                </span>

                                            @endif

                                        </td>


                                        {{-- DATE --}}
                                        <td>

                                            {{ $item->created_at
                                                ? $item->created_at->format('d M Y, h:i A')
                                                : 'N/A'
                                            }}

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="py-4 text-center text-muted"
                                        >

                                            No messages found.

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

</div>

@endsection
