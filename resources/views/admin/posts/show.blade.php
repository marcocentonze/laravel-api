@extends('layouts.admin')

@section('content')
    <div class="container py-4 mt-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    @if (str_contains($project->cover_image, 'http'))
                                        <img class="card-img img-fluid rounded" src="{{ asset($project->cover_image) }}"
                                            alt="img">
                                    @else
                                        <img class="card-img img-fluid rounded"
                                            src="{{ asset('storage/' . $project->cover_image) }}" alt="img">
                                    @endif

                    <div class="card-header">
                        <h4 class="card-title">{{ $project->title }}</h4>
                        <h6 class="card-subtitle text-muted">{{ $project->created_at->format('F d, Y H:i:s') }}</h6>
                    </div>

                    <div class="card-body">
                        <p class="card-text">{{ $project->description }}</p>
                        <p><strong>Type: </strong>{{ $project->type?->name ?? 'Uncategorized' }}</p>  {{-- null safe operator --}}  
                       
                        <p><strong>Technologies used:</strong></p>

                        <div class="d-flex">
                            <ul class="d-flex gap-2 list-unstyled">
                                @forelse ($project->technologies as $technology)
                                    <li class="badge bg-success">
                                        <i class="fa-solid fa-code"></i> {{ $technology->name }}
                                    </li>
                                @empty
                                    <li class="badge bg-secondary"><i class="fa-regular fa-file"></i> None/Others</li>
                                @endforelse
                            </ul>
                        </div>
                        
                        <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
