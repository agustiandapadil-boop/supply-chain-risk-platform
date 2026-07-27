@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add New Port</h2>
    <a href="{{ route('ports.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card card-admin p-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ports.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="country_id" class="form-label">Country <span class="text-danger">*</span></label>
                <select name="country_id" id="country_id" class="form-control" required>
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                            {{ $country->country_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="port_name" class="form-label">Port Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="port_name" name="port_name" value="{{ old('port_name') }}" required>
            </div>

            <div class="col-md-6">
                <label for="harbor_size" class="form-label">Harbor Size</label>
                <input type="text" class="form-control" id="harbor_size" name="harbor_size" value="{{ old('harbor_size') }}">
            </div>

            <div class="col-md-6">
                <label for="harbor_type" class="form-label">Harbor Type</label>
                <input type="text" class="form-control" id="harbor_type" name="harbor_type" value="{{ old('harbor_type') }}">
            </div>

            <div class="col-md-6">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}">
            </div>

            <div class="col-md-6">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}">
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Save Port</button>
            </div>
        </div>
    </form>
</div>
@endsection
