@extends('layouts.admin')

@section('title', 'Index Admin')

@section('content')

    <div class="container mt-5">
        <h1 class="mb-4">Index Admin
            <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-primary float-end">Create New Project</a>
        </h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                <strong>Success!</strong> {{ session('message') }}
            </div>
        @endif

        {{-- Alert when empty --}}
        @if ($projects->isEmpty())
            <div class="alert alert-warning" role="alert">
                No projects here yet!
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered shadow-sm">
                    <thead>
                        <tr>
                            <th scope="col" class="py-2 px-3">ID</th>
                            <th scope="col" class="py-2 px-3">Title</th>
                            <th scope="col" class="py-2 px-3">Image</th>
                            <th scope="col" class="py-2 px-3">Description</th>
                            <th scope="col" class="py-2 px-3">Links</th>
                            <th scope="col" class="py-2 px-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="py-2 px-3">{{ $project->id }}</td>
                                <td class="py-2 px-3">{{ $project->title }}</td>
                                <td class="py-2 px-3">
                                    {{-- <img width="150" src="{{ asset('storage/' . $project->cover_image) }}"
                                        alt="Cover image for {{ $project->title }}" class="img-fluid rounded"> --}}
                                    @if (str_contains($project->cover_image, 'http'))
                                        <img class="card-img img-fluid rounded" src="{{ asset($project->cover_image) }}"
                                            alt="img">
                                    @else
                                        <img class="card-img img-fluid rounded"
                                            src="{{ asset('storage/' . $project->cover_image) }}" alt="img">
                                    @endif
                                </td>
                                <td class="py-2 px-3">{{ $project->description }}</td>
                                   {{-- Links --}}
                                <td class="py-2 px-3">

                                    <a class="btn btn-dark m-1" href="{{ $project->github_link }}">
                                        <i class="fa-brands fa-github"></i>
                                    </a>

                                    <a class="btn m-1"
                                    href="{{ $project->website_link }}"
                                        style="background-color: #e9ecef">
                                        <i class="fas fa-globe" style="color:#007bff"></i>
                                    </a>

                                </td>

                                <td class="text-center text-nowrap">

                                    {{-- more button --}}
                                    <a class="btn btn-primary " href="{{ route('admin.projects.show', $project->slug) }}"
                                        title="More">
                                        <i class="fa-solid fa-circle-info"></i> </a>

                                    {{-- edit button --}}
                                    <a class="btn btn-warning my-2"
                                        href="{{ route('admin.projects.edit', $project->slug) }}" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Modal delete trigger button -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalId-{{ $project->id }}" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>


                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div class="modal fade" id="modalId-{{ $project->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitleId-{{ $project->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-nowrap"
                                                        id="modalTitleId-{{ $project->id }}">
                                                        <i class="fa-solid fa-triangle-exclamation pe-2 text-warning"></i>
                                                        Deleting project
                                                        #{{ $project->id }} <i
                                                            class="fa-solid fa-triangle-exclamation ps-2 text-warning"></i>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Danger! This cannot be undone.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <form action="{{ route('admin.projects.destroy', $project->slug) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                            Confirm
                                                        </button>
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
                @include('partials.pagination')
            </div>
        @endif
    </div>

@endsection
