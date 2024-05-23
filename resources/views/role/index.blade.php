@extends('layout')
@section('title', 'Roles')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col">
                                        <h4 class="card-title mb-0">Roles</h4>
                                    </div>
                                    <div class="col-sm-auto">
                                        @if (auth()->user()->authorize('roles.create'))
                                            <a href="{{ route('roles.create') }}">
                                                <button type="button" class="btn btn-success add-btn">
                                                    <i class="ri-add-line align-bottom me-1"></i> Add
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="accountCategoryList">
                                    <div class="card-body">
                                        <table id="roleTable" class="table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>{{ __('S/N') }}</th>
                                                    <th>{{ __('Name') }}</th>
                                                    <th>{{ __('Display Name') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                    <th>{{ __('Description') }}</th>
                                                    <th>{{ __('Updated By') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end col -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom-script')


    <script type="text/javascript">
        $(document).ready(function() {
            var searchable = [];
            var selectable = [];
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });

            var dTable = $('#roleTable').DataTable({
                order: [],
                lengthRole: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                processing: true,
                responsive: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'collection',
                    text: 'Export',
                    buttons: [
                        @if (auth()->user()->authorize('roles.download'))
                            {
                                extend: 'collection',
                                text: 'Export',
                                buttons: [
                                    'copy',
                                    'excel',
                                    'csv',
                                    'pdf',
                                    'print'
                                ]
                            },
                        @endif
                    ],
                }],
                dom: "<'row'<'col-sm-4'l><'col-sm-5 text-center mb-2'B><'col-sm-3'f>>tipr",
                language: {
                    processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
                },
                scroller: {
                    loadingIndicator: false
                },
                pagingType: "full_numbers",
                ajax: {
                    url: "{{ route('roles.index') }}",
                    type: "get"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'display_name',
                        name: 'display_name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'updated_by',
                        name: 'updated_by',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });

        const deleteRole = (id) => {
            var token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ route('roles.destroy') }}';
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {
                            "role_id": id,
                            "_token": token,
                        },
                        success: function(data) {
                            if (data.success) {
                                toaster(data.success, 'success');
                            } else {
                                toaster(data.error, 'danger');
                            }
                            $('#roleTable').DataTable().ajax.reload();

                        }
                    });
                }
            })
        }
    </script>
@endsection
