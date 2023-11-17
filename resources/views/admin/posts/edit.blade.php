@extends('layouts.admin')

@section('content')

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title mb-4">Edit Project</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><strong>Error! </strong> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.projects.update', ['project' => $project]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Project Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            placeholder="Enter project title" value="{{ old('title', $project->title) }}">

                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Project Image</label>
                        <input type="file" name="cover_image" id="cover_image" class="form-control">

                        @error('cover_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="description" class="form-label">Project Description</label>
                        <textarea class="form-control" name="description" id="description" rows="5"
                            placeholder="Enter project description">{{ old('descritpion', $project->description) }}</textarea>

                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type_id" class="form-label">Type</label>
                        <select class="form-select form-select @error('type_id') is-invalid @enderror" name="type_id"
                            id="type_id">
                            <option selected disabled>Select a Type</option>
                            <option value="">Uncategorized</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}"
                                    {{ $type->id == old('type_id', $project->type_id) ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('type_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="technologies" class="form-label"><strong>Technologies Used</strong></label>
                        <div id="technologies">
                            @foreach ($technologies as $technology)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="technologies[]"
                                        id="tech-{{ $technology->id }}" value="{{ $technology->id }}"
                                        @if ($errors->any()) {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}
                                           @else
                                               {{ $project->technologies->contains($technology) ? 'checked' : '' }} @endif>
                                    <label class="form-check-label" for="tech-{{ $technology->id }}">
                                        {{ $technology->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    @error('technologies')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
            </div>


            <div class="mb-3 ps-3">
                <label for="github_link" class="form-label">Edit your github Link</label>
                <input type="url" name="github_link" id="github_link" class="form-control"
                    placeholder="Edit github project link" aria-describedby="helpId"
                    value="{{ old('github_link', $project->github_link) }}">
            </div>

            <div class="mb-3 ps-3">
                <label for="website_link" class="form-label">Edit your website Link</label>
                <input type="url" name="website_link" id="website_link" class="form-control"
                    placeholder="Edit website project link" aria-describedby="helpId"
                    value="{{ old('website_link', $project->website_link) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Project</button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>

            </form>
        </div>
    </div>
    </div>

@endsection
