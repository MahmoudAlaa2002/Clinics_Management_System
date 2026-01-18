@extends('Backend.patients.master')

@section('title','Upload Payment Receipt')

@section('content')

<div class="container" style="max-width:600px;margin-top:60px">
    <h3 class="text-center mb-4" style="color:#00A8FF">Upload Proof of Payment</h3>

    <form id="bankReceiptForm" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Reference Number <span class="text-danger">*</span></label>
            <input type="text" id="reference_number" name="reference_number" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Receipt (Screenshot) <span class="text-danger">*</span></label>
            <input type="file" id="receipt" name="receipt" class="form-control" accept="image/*">
        </div>

        <button id="submitReceipt" class="btn btn-primary w-100" style="margin:40px 0;background:#00A8FF">
            Submit for Verification
        </button>

    </form>

</div>
@endsection


@section('js')
<script>
    $(document).ready(function () {

        $('#submitReceipt').click(function (e) {
            e.preventDefault();

            let reference = $('#reference_number').val();
            let receipt   = $('#receipt')[0].files[0];

            if (reference === '' || receipt === undefined) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter reference number and upload receipt',
                    confirmButtonColor: '#00A8FF'
                });
                return;
            }

            let formData = new FormData();
            formData.append('reference_number', reference);
            formData.append('receipt', receipt);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: "{{ route('patient.bank.qr.store',$hold->id) }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function(response){
                    if(response.status === 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Submitted',
                            text: 'Your payment is under verification',
                            confirmButtonColor: '#00A8FF'
                        }).then(() => {
                            window.location.href = "/patient/home";
                        });
                    }
                    else{
                        Swal.fire('Error', response.message, 'error');
                    }
                },

                error: function(xhr){
                    Swal.fire('Error','Something went wrong','error');
                }
            });

        });

    });
</script>
@endsection