@extends('Backend.patients.master')

@section('title', 'Clinics')

@section('content')

    <style>
        .dept-list {
            list-style: none;
            padding-left: 0;
        }

        .dept-list li::before {
            content: "• ";
            margin-left: 25px;
        }

        .pagination-wrapper {
            margin-top: auto;
            padding-top: 80px;
            padding-bottom: 30px;
        }

        .pagination .page-link {
            background-color: #fff;
            color: #007BFF;
        }

        /* الصفحة الحالية فقط */
        .pagination .page-item.active .page-link {
            background-color: #007BFF;
            color: #fff;
            border-color: #007BFF;
        }

        /* Hover عادي */
        .pagination .page-link:hover {
            background-color: #f1f5ff;
            color: #007BFF;
        }

    </style>

    <main class="main">
        <section class="ourClinics">
            <div class="container mt-5 mb-6 header-ourClinics">

                <!-- Header + Search -->
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <h2 class="section-title" style="color: #007BFF">Our Clinics</h2>

                        <form class="form d-flex justify-content-center gap-3">
                            <input type="text" id="search_input" placeholder="Search clinics...">
                            <select id="search_filter">
                                <option disabled selected hidden>Search by</option>
                                <option value="clinic">Clinic Name</option>
                                <option value="department">Department</option>
                                <option value="rating">Rating</option>
                            </select>
                        </form>

                    </div>
                </div>

                <!-- Clinics -->
                <div class="row" id="clinics_container">
                    @include('Backend.patients.clinics.search', ['clinics' => $clinics])
                </div>


                <div id="clinics-pagination" class="pagination-wrapper d-flex justify-content-center">
                    {{ $clinics->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </section>
    </main>
@endsection


@section('js')
    <script>
        let lastKeyword = '';

        function fetchClinics(url) {
            if (typeof url !== 'string') {
                url = "{{ route('patient.search_clinics') }}";
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

                    $('#clinics_container').html(response.html);

                    if (response.searching) {
                        if (response.count > 9) {
                            $('#clinics-pagination').html(response.pagination).show();
                        } else {
                            $('#clinics-pagination').empty().hide();
                        }
                    } else {
                        $('#clinics-pagination').show();
                    }
                },

                error: function () {
                    console.error("Search failed");
                }
            });
        }

        $('#search_input').on('input', fetchClinics);
        $('#search_filter').on('change', fetchClinics);

        $(document).on('click', '#clinics-pagination .page-link', function (e) {

            let keyword = $('#search_input').val().trim();

            if (keyword !== '') {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url && url !== '#') fetchClinics(url);
            }
        });
    </script>
@endsection
