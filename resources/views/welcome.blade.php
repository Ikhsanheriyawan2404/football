@extends('layouts.app')

@section('content')

    <table class="table table-hovered table-sm table-bordered" id="datatables">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Klub</th>
                <th>P</th>
                <th>Me</th>
                <th>S</th>
                <th>K</th>
                <th>GM</th>
                <th>GK</th>
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
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'club.name', name: 'club.name' },
                    { data: 'points', name: 'points' },
                    { data: 'wins', name: 'wins' },
                    { data: 'draws', name: 'draws' },
                    { data: 'losses', name: 'losses' },
                    { data: 'goals_for', name: 'goals_for' },
                    { data: 'goals_against', name: 'goals_against' },
                ]
            });
        });
    </script>
@endpush
