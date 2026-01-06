@extends('Backend.patients.master')

@section('title', 'Doctors')

@section('content')

    <style>
        .pagination-wrapper {
                margin-top: auto;
                padding-top: 80px;
                padding-bottom: 30px;
            }

            .pagination .page-link {
                background-color: #fff;
                color: #00A8FF;
            }

            /* الصفحة الحالية فقط */
            .pagination .page-item.active .page-link {
                background-color: #00A8FF;
                color: #fff;
                border-color: #00A8FF;
            }

            /* Hover عادي */
            .pagination .page-link:hover {
                background-color: #f1f5ff;
                color: #00A8FF;
            }
    </style>

    <main class="main">
        <section class="ourDoctors">
            <div class="container mt-5 mb-6 header-ourDoctors">

                <!-- Header + Search -->
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <h2 class="section-title" style="color:#00A8FF">Our Doctors</h2>

                        <form class="form d-flex justify-content-center gap-3">
                            <input type="text" id="search_input" placeholder="Search doctors...">

                            <select id="search_filter">
                                <option disabled selected hidden>Search by</option>
                                <option value="doctor">Doctor Name</option>
                                <option value="clinic">Clinic</option>
                                <option value="department">Department</option>
                                <option value="rating">Rating</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Doctors -->
                <div class="row" id="doctors_container">
                    @include('Backend.patients.doctors.search', ['doctors' => $doctors])
                </div>



                <div id="doctors-pagination" class="pagination-wrapper d-flex justify-content-center">
                    {{ $doctors->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </section>
    </main>
@endsection


@section('js')
    <script>
        let lastKeyword = '';

        function fetchDoctors(url) {
            if (typeof url !== 'string') {
                url = "{{ route('patient.search_doctors') }}";
            }

            let keyword = $('#search_input').val().trim();
            let filter  = $('#search_filter').val();

            if (keyword === '' && lastKeyword === '') return;

            if (keyword === '' && lastKeyword !== '') {
                lastKeyword = '';
                window.location.reload();
                return;
            }

            lastKeyword = keyword;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: { keyword: keyword, filter: filter },

                success: function (response) {

                    $('#doctors_container').html(response.html);

                    if (response.searching) {
                        if (response.count > 12) {
                            $('#doctors-pagination').html(response.pagination).show();
                        } else {
                            $('#doctors-pagination').empty().hide();
                        }
                    } else {
                        $('#doctors-pagination').show();
                    }
                },

                error: function () {
                    console.error("Search failed");
                }
            });
        }

        $('#search_input').on('input', fetchDoctors);
        $('#search_filter').on('change', fetchDoctors);

        $(document).on('click', '#doctors-pagination .page-link', function (e) {

            let keyword = $('#search_input').val().trim();

            if (keyword !== '') {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url && url !== '#') fetchDoctors(url);
            }
        });

    </script>
@endsection
