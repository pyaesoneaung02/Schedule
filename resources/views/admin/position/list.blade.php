@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-gray-800 h3">Positions List</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4">
                    <div class="text-white rounded card bg-info">
                        <div class="shadow card-body">
                            <form action="{{ route('position.create')}}" method="POST" class="p-3 rounded">
                                @csrf
                                <label class="form-label">Position</label>
                                <input type="text" name="positionName" value="{{ old('positionName')}}" class="form-control @error('positionName') is-invalid @enderror" placeholder="Position Name...">
                                @error('positionName')
                                    <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                                <input type="submit" value="Create" class="mt-3 btn btn-outline-danger">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <table class="table shadow-sm table-hover">
                      <thead class="text-white bg-danger">
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Name</th>
                          <th scope="col">Created Date</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($positions) != 0)
                        @foreach ($positions as $item)
                            <tr>
                            <td>{{ $item->id}}</td>
                            <td>{{ $item->name}}</td>
                            <td>{{ $item->created_at->format('j-F-Y')}}</td>
                            <td>
                                <a href="{{ route('position.updatePage', $item->id)}}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="{{ route('position.delete', $item->id)}}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4"><h5 class="text-center text-muted">There is no data</h5></td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
                    <span class="d-flex justify-content-end">{{ $positions->links() }}</span>
                </div>
            </div>
        </div>

    </div>

    @endsection
