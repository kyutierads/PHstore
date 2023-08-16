@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/brand.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- <form id="importForm" action="{{ route('import.brands') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <input class="form-control col-md-8" type="file" name="excel_file">
                        <button type="submit" class="btn btn-dark col-md-4">Import Excel</button>
                    </div>
                </form> --}}
                <table id="shippingTable" class="table">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">ID</th>
                            <th scope="col">Type</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLongTitle">Create Shipping Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="shippingForm">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" class="form-control" id="type" name="type">
                        </div>
                        {{-- <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" placeholder="Enter Slug"
                                name="slug">
                        </div>
                        <div class="form-group">
                            <label for="Description">Description</label>
                            <input type="text" class="form-control" id="description" placeholder="Enter Description"
                                name="description">
                        </div> --}}
                        <div class="form-group">
                            <label for="delivery_image">Image</label>
                            <input type="file" class="form-control" id="delivery_image" name="delivery_image[]" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="save" type="button" class="btn btn-primary">Save</button>
                    <button id="update" type="button" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        initilizeDropzone();
        var uploadedDocumentMap = {}

        function initilizeDropzone() {
            Dropzone.options.dropzoneImage = {
                url: '{{ route('category.storeMedia') }}',
                // maxFilesize: 2,
                // acceptedFiles: 'image/*',
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                    uploadedDocumentMap[file.name] = response.name
                },
                removedfile: function(file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedDocumentMap[file.name]
                    }
                    $('form').find('input[name="document[]"][value="' + name + '"]').remove()
                },
                error: function(file) {
                    alert("Only image will be accepted.");
                    file.previewElement.remove();
                    $('.dz-message').css({
                        display: "block",
                    })
                },
                init: function() {
                    @if (isset($project) && $project->document)
                        var files = {!! json_encode($project->document) !!}
                        for (var i in files) {
                            var file = files[i]
                            this.options.addedfile.call(this, file)
                            file.previewElement.classList.add('dz-complete')
                            $('form').append('<input type="hidden" name="document[]" value="' + file.file_name +
                                '">')
                        }
                    @endif
                },
            }
        }
    </script>
@endsection --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="{{ asset('js/shipping.js') }}"></script>
@endsection
