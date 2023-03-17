@extends('layouts.app')

@section('content')

    <button id="createNewItem" class="btn btn-sm btn-primary">Tambah Pertandinagn</button>
    <table class="table table-hovered table-sm table-bordered" id="datatables">
        <thead>
            <tr>
                <th>No</th>
                <th>Home</th>
                <th>Away</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="itemForm">
                @csrf
                <input type="hidden" name="item_id" id="item_id">
                <div class="modal-body">
                    <button class="btn btn-sm btn-primary" id="btnAddElement">Tambah <i class="bi bi-plus"></i></button>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="home_club_id">Home Club</label>
                                <select type="text" name="home_club_id[]" class="form-control form-control-sm" id="home_club_id"></select>
                            </div>
                            <div class="form-group">
                                <label for="home_score">Home Score</label>
                                <input type="number" name="home_score[]" class="form-control form-control-sm" id="home_score">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="away_club_id">Away Klub</label>
                                <select type="text" name="away_club_id[]" class="form-control form-control-sm" id="away_club_id"></select>
                            </div>
                            <div class="form-group">
                                <label for="away_score">Away Score</label>
                                <input type="number" name="away_score[]" class="form-control form-control-sm" id="away_score">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for=""></label>
                                <button class="form-control form-control-sm btn btn-danger btn-sm removeItem"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary btn-sm">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script>

    <script>
        $(document).ready(function() {
            let table = $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('games.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'home.name', name: 'home.name' },
                    { data: 'away.name', name: 'away.name' },
                ]
            });

            function putOptionValue(identifier, response)
            {
                let vendorOption = ['<option selected disabled>Pilih Klub</option>']
                $.each(response, function(key, value) {
                    vendorOption += `<option value="${value.id}">${value.name}</option>`;
                });
                $(identifier).html(vendorOption);
            }

            $.ajax({
                type: "GET",
                url: "{{ route('clubs.data') }}",
                success: function(response) {
                    putOptionValue('body #home_club_id', response);
                    putOptionValue('body #away_club_id', response);
                }
            })

            $('body').on('click', '#btnAddElement', function(e) {
                e.preventDefault();

                var body = $('.modal-body');
                var html = `
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="home_club_id">Home Club</label>
                            <select type="text" name="home_club_id[]" class="form-control form-control-sm" id="home_club_id"></select>
                        </div>
                        <div class="form-group">
                            <label for="home_score">Home Score</label>
                            <input type="number" name="home_score[]" class="form-control form-control-sm" id="home_score">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="away_club_id">Away Klub</label>
                            <select type="text" name="away_club_id[]" class="form-control form-control-sm" id="away_club_id"></select>
                        </div>
                        <div class="form-group">
                            <label for="away_score">Away Score</label>
                            <input type="number" name="away_score[]" class="form-control form-control-sm" id="away_score">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for=""></label>
                            <button class="form-control form-control-sm btn btn-danger btn-sm removeItem"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
                `;

                body.append(html);

                $.ajax({
                    type: "GET",
                    url: "{{ route('clubs.data') }}",
                    success: function(response) {
                        putOptionValue('body #home_club_id', response);
                        putOptionValue('body #away_club_id', response);
                    }
                })

            })

            $('body').on('click', '.removeItem', function(e) {
                e.preventDefault();
                $(this).parents('div.row').remove();
            });


            $('#createNewItem').click(function() {
                setTimeout(function() {
                    $('#name').focus();
                }, 500);
                $('#saveBtn').removeAttr('disabled');
                $('#saveBtn').html("Save Changes");
                $('#item_id').val('');
                $('#itemForm').trigger("reset");
                $('#exampleModal').modal('show');
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $('#saveBtn').attr('disabled', 'disabled');
                $('#saveBtn').html('Save Changes ...');
                var formData = new FormData($('#itemForm')[0]);
                $.ajax({
                    data: formData,
                    url: "{{ route('games.store') }}",
                    contentType: false,
                    processData: false,
                    type: "POST",
                    success: function(data) {
                        $('#itemForm').trigger("reset");
                        $('#exampleModal').modal('hide');
                        table.draw();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                        });
                    },
                    error: function(data) {
                        $('#saveBtn').removeAttr('disabled');
                        $('#saveBtn').html("Save Changes");
                        Swal.fire({
                            icon: 'error',
                            title: 'Oppss',
                            text: data.responseJSON.message,
                        });
                    }
                });
            });
        });
    </script>
@endpush
