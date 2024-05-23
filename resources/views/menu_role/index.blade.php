@extends('layout')
@section('title', 'Menu Role')
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
                                        <h4 class="card-title mb-0">Menu Role</h4>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body">
                                <div id="accountCategoryList">
                                    <div class="card-body">
                                        <table id="menuRoleTable" class="table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>{{ __('Menu') }}</th>
                                                    <th>{{ __('Role') }}</th>
                                                    <th>{{ __('Acc View') }}</th>
                                                    <th>{{ __('Acc Create') }}</th>
                                                    <th>{{ __('Acc Edit') }}</th>
                                                    <th>{{ __('Acc Delete') }}</th>
                                                    <th>{{ __('Acc Download') }}</th>
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

            var dTable = $('#menuRoleTable').DataTable({
                order: [],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                processing: true,
                responsive: true,
                serverSide: false,
                dom: 'Bfrtip',
                buttons: [
                    @if (auth()->user()->authorize('menu_roles.download'))
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
                        }
                    @endif
                ],
                dom: "<'row'<'col-sm-4'l><'col-sm-5 text-center mb-2'B><'col-sm-3'f>>tipr",
                language: {
                    processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
                },
                scroller: {
                    loadingIndicator: false
                },
                pagingType: "full_numbers",
                ajax: {
                    url: "{{ route('menu_roles.index') }}",
                    type: "get"
                },
                columns: [{
                        data: 'menu_name',
                        name: 'Menu',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'role_name',
                        name: 'Role',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'acc_view',
                        name: 'Acc View',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'acc_create',
                        name: 'Acc Create',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'acc_edit',
                        name: 'Acc Edit',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'acc_delete',
                        name: 'Acc Delete',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'acc_download',
                        name: 'Acc Download',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'updated_by',
                        name: 'Updated By',
                        orderable: true,
                        searchable: false
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
    </script>
@endsection
