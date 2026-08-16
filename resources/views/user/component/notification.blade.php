@extends('user.layouts.master')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h3 class="mb-4">Message Notifications & Status</h3>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notifications as $item)
                                    <tr>
                                        <td class="fw-semibold">{{ $item->subject ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($item->message, 40) }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $item->status == 'success' ? 'success' : 'warning text-dark' }}">
                                                {{ ucfirst($item->status ?? 'pending') }}
                                            </span>
                                        </td>
                                        <td>{{ $item->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No messages found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
