@extends('admin.layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Create Article</h2>
        <small class="text-muted">Write a new analysis article</small>
    </div>
    <a href="/admin/articles" class="btn btn-outline-dark">Back</a>
</div>

<div class="card card-admin p-4">

    <form method="POST" action="/admin/articles">
        @csrf

        <div class="row g-3">

            <div class="col-md-8">
                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input
                    type="text"
                    name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}"
                    placeholder="Article title..."
                    required
                >
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                    <option value="">Select category</option>
                    <option value="Risk Analysis"      {{ old('category') == 'Risk Analysis' ? 'selected' : '' }}>Risk Analysis</option>
                    <option value="Trade Intelligence" {{ old('category') == 'Trade Intelligence' ? 'selected' : '' }}>Trade Intelligence</option>
                    <option value="Weather Impact"     {{ old('category') == 'Weather Impact' ? 'selected' : '' }}>Weather Impact</option>
                    <option value="Port Operations"    {{ old('category') == 'Port Operations' ? 'selected' : '' }}>Port Operations</option>
                    <option value="Currency Trends"    {{ old('category') == 'Currency Trends' ? 'selected' : '' }}>Currency Trends</option>
                    <option value="Geopolitics"        {{ old('category') == 'Geopolitics' ? 'selected' : '' }}>Geopolitics</option>
                    <option value="General"            {{ old('category') == 'General' ? 'selected' : '' }}>General</option>
                </select>
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Country (Optional)</label>
                <select name="country_id" class="form-select">
                    <option value="">Global / No specific country</option>
                    @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ old('country_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->country_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="draft"     {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Summary</label>
                <textarea
                    name="summary"
                    class="form-control"
                    rows="2"
                    placeholder="Short summary of the article..."
                >{{ old('summary') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                <textarea
                    name="content"
                    id="content"
                    class="form-control @error('content') is-invalid @enderror"
                    rows="14"
                    placeholder="Full article content..."
                    required
                >{{ old('content') }}</textarea>
                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-danger px-4">Save Article</button>
                <a href="/admin/articles" class="btn btn-outline-secondary">Cancel</a>
            </div>

        </div>
    </form>
</div>

@endsection
