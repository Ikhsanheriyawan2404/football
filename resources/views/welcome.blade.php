@extends('layouts.app')

@section('content')

    <table class="table table-hovered table-sm table-bordered" id="datatables">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Club</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

@endsection

@push('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('standings') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                ]
            });
        });
    </script>
@endpush
