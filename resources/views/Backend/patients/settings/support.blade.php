@extends('Backend.patients.master')

@section('title', 'Support')

@section('content')

<section id="contact" class="contact section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Contact</h2>
      <p>Have a question or need assistance? We’re here to help — get in touch with us anytime</p>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        <div class="col-lg-4">
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h3>Address</h3>
              <p>{{ $admin->address }}</p>
            </div>
          </div>

          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
            <i class="bi bi-telephone flex-shrink-0"></i>
            <div>
              <h3>Call Us</h3>
              <p>{{ $admin->phone }}</p>
            </div>
          </div>

          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
            <i class="bi bi-envelope flex-shrink-0"></i>
            <div>
              <h3>Email Us</h3>
              <p>{{ $admin->email }}</p>
            </div>
          </div>

        </div>

        <div class="col-lg-8">
          <form action="{{ route('contact_send') }}" method="POST">
            <div class="row gy-4">

              <div class="col-md-6">
                <input type="text" id="name" name="name" class="form-control" placeholder="Your Name">
              </div>

              <div class="col-md-6 ">
                <input type="email" id="email" class="form-control" name="email" placeholder="Your Email">
              </div>

              <div class="col-md-12">
                <input type="text" id="subject" class="form-control" name="subject" placeholder="Subject">
              </div>

              <div class="col-md-12">
                <textarea class="form-control" id="message" name="message" rows="6" placeholder="Message"></textarea>
              </div>

              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary submit-btn addBtn" style="background-color: #00A8FF;">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

@endsection


@section('js')
<script>
    $('.addBtn').click(function (e) {
        e.preventDefault();

        let name = $('#name').val().trim();
        let email = $('#email').val().trim();
        let subject = $('#subject').val().trim();
        let message = $('#message').val();


        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('subject', subject);
        formData.append('message', message);

        if(name === '' || email === '' || subject === '' || message === ''){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter all required fields',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#00A8FF',
            });
        }else{
            $.ajax({
                method: 'POST',
                url: "{{ route('contact_send') }}",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.data == 1) {
                        Swal.fire({
                            title: 'Success',
                            text: 'The message has been sent successfully',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#00A8FF',
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                }
            });
        }
    });
</script>
@endsection
