@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>نداءات الاستغاثة</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Description</th>
                <th>Status</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($calls as $call)
                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->name }}</td>
                    <td>{{ $call->phone_number }}</td>
                    <td>{{ $call->detailed_address }}</td>
                    <td>{{ $call->description }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $call->status }}
                        </span>
                    </td>
                    <td>
                        <!-- Delete -->
                        <form action="{{ route('distress-calls.destroy', $call->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>

                        <!-- Update Status -->
                        <form action="{{ route('distress-calls.update', $call->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                <option value="pending" {{ $call->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $call->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $call->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="cancelled" {{ $call->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No calls found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
