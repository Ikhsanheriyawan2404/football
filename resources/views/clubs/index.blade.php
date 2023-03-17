@extends('layouts.app')

@section('content')
    <a id="createNewItem" class="btn btn-sm btn-primary">Tambah</a>
    <table class="table table-hovered table-sm table-bordered" id="datatables">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Klub</th>
                <th>Wilay</th>
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
                    <div class="form-group">
                        <label for="name">Nama Klub</label>
                        <input type="text" name="name" class="form-control form-control-sm" id="name">
                    </div>
                    <div class="form-group">
                        <label for="city">Wilayah Klub/Kota</label>
                        <input type="text" name="city" class="form-control form-control-sm" id="city">
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
                ajax: "{{ route('clubs.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                ]
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

            $('body').on('click', '#editItem', function() {
                var item_id = $(this).data('id');
                $.get("{{ route('clubs.index') }}" + '/' + item_id + '/edit', function(data) {
                    $('#exampleModal').modal('show');
                    setTimeout(function() {
                        $('#name').focus();
                    }, 500);
                    $('#saveBtn').removeAttr('disabled');
                    $('#saveBtn').html("Save Changes");
                    $('#item_id').val(data.id);
                    $('#name').val(data.name);
                    $('#city').val(data.city);
                })
            });


            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $('#saveBtn').attr('disabled', 'disabled');
                $('#saveBtn').html('Save Changes ...');
                var formData = new FormData($('#itemForm')[0]);
                $.ajax({
                    data: formData,
                    url: "{{ route('clubs.store') }}",
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
