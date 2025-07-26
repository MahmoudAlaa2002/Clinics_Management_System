@extends('Backend.master')

@section('title' , 'Edit Specialty')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Edit Specialty</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('update_specialty' , ['id' => $specialty->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="name">Specialty Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-stethoscope"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter specialty name" value="{{ $specialty->name }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Specialty Description <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Write a short description about the clinic...">{{ old('description', $specialty->description ?? '') }}</textarea>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Specialty</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let name = $('#name').val().trim();
                let description = $('#description').val().trim();

                if(name === ''){
                    Swal.fire({
                        title: 'Error!',
                        text: ' Please Enter The Specialty Name',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }else{
                    $.ajax({
                    method: 'POST',
                    url: "{{ route('update_specialty', ['id' => $specialty->id]) }}",
                    data: {
                        _method: 'PUT',
                        name: name,
                        description: description,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Specialty has been updated successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('view_specialties') }}";
                            });
                        }
                    },
                });
            }
        });
    });
    </script>
@endsection
