@extends('admin.layout.template')

@section('content')
    <form id="save-form">
        @csrf
        @foreach ($_locales as $locale)
            <div class="mb-3 mt-3">
                <label class="form-label">Name - {{ $locale }}: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Product name" name="name:{{ $locale }}">
                <div class="invalid-feedback"></div>
            </div>
        @endforeach

        <div class="mb-3">
            <label class="form-label">Parent category:</label>
            <select class="form-control select2" name="parent_id">
                <option value="" selected disabled>Select a parent category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#save-form").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    url: route("categories.save"),
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Do something ...
                    },
                    error: function(xhr) {
                        viewSaveErrorAlert(xhr.status);
                        if (xhr.status === 422) {
                            renderValidationErrors(xhr.responseJSON);
                        }
                    }
                });
            });
        });
    </script>
@endsection
