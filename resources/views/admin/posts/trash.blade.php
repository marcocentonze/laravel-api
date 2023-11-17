@extends('layouts.admin')

@section('title', 'Index Admin')

@section('content')

    <div class="container mt-5">


        @if (session('message'))
            <div class="alert alert-success" role="alert">
                <strong>Success!</strong> {{ session('message') }}
            </div>
        @endif

        {{-- Alert when empty --}}
        @if ($trashedProjects->isEmpty())
            <div class="alert alert-warning" role="alert">
                No deleted projects here!
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered shadow-sm">
                    <thead class="bg-info">
                        <tr>
                            <th scope="col" class="py-2 px-3">ID</th>
                            <th scope="col" class="py-2 px-3">Title</th>
                            <th scope="col" class="py-2 px-3">Image</th>
                            <th scope="col" class="py-2 px-3">Description</th>
                            <th scope="col" class="py-2 px-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trashedProjects as $project)
                            <tr>
                                <td class="py-2 px-3">{{ $project->id }}</td>
                                <td class="py-2 px-3">{{ $project->title }}</td>
                                <td class="py-2 px-3">
                                    {{-- <img width="150" src="{{ asset('storage/' . $project->cover_image) }}"
                                        alt="Cover image for {{ $project->title }}" class="img-fluid rounded"> --}}
                                        @if (str_contains($project->cover_image, 'http'))
                                                    <img class="card-img" src="{{ asset($project->cover_image) }}"
                                                        alt="img">
                                                @else
                                                    <img class="card-img"
                                                        src="{{ asset('storage/' . $project->cover_image) }}"
                                                        alt="img">
                                                @endif
                                </td>
                                <td class="py-2 px-3">{{ $project->description }}</td>
                                <td>
                                    <!-- Modal trigger button -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modalId-restore-{{ $project->id }}">
                                        <i class="fas fa-undo"></i>
                                        Restore
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div class="modal fade" id="modalId-restore-{{ $project->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId">Restoring Project
                                                        {{ $project->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Do you want to restore this project?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <form
                                                        action="{{ route('admin.restore', ['project' => $project->slug]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-undo"></i>Restore</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal trigger button -->
                                    <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal"
                                        data-bs-target="#modalId-force-delete-{{ $project->id }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                        Delete
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div class="modal fade" id="modalId-force-delete-{{ $project->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitleId-{{ $project->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId-{{ $project->id }}">Deleting
                                                        project
                                                        #{{ $project->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Danger! This cannot be undone.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <form
                                                        action="{{ route('admin.forceDestroy', ['project' => $project->slug]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- @include('partials.pagination') --}}
            </div>
        @endif
    </div>

@endsection
