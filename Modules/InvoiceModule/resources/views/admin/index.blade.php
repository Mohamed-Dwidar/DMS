@extends('layoutmodule::main')

@section('title')
    {{ __('messages.invoices') }}
@endsection



@push('styles')
@endpush

@section('content')

    <div class="card-header">
        <div class="d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ route('invoices.add') }}">{{ __('messages.add_new') }}</a>
        </div>
    </div>

    <div class="card-body table-border-style">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th class="align-middle">{{ __('messages.invoice_number') }}</th> --}}
                        <th class="align-middle">{{ __('messages.invoice_name') }}</th>
                        <th class="align-middle">{{ __('messages.prices') }}</th>
                        <th class="align-middle">{{ __('messages.hotel') }}</th>
                        <th class="align-middle">{{ __('messages.week_start') }}</th>
                        <th class="align-middle">{{ __('messages.image') }}</th>
                        <th class="align-middle">{{ __('messages.status') }}</th>
                        <th class="align-middle">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($invoices))
                        @foreach ($invoices as $invoice)
                            <tr>
                                {{-- <td>{{ $invoice->id }}</td> --}}
                                <td>{{ $invoice->name }}</td>
                                <td>
                                </td>
                                <td>
                                    {{ $invoice->hotel }}
                                </td>
                                <td>
                                    {{ $invoice->week_start }}
                                </td>
                                <td>
                                    <img src="{{ $invoice->imagePath }}" alt="{{ $invoice->name }}" class="img-fluid"
                                        style="max-width: 100px; max-height: 100px;">
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        @if ($invoice->is_active)
                                            <i class="ti ti-check text-success" title="{{ __('messages.active') }}"></i>
                                        @else
                                            <i class="ti ti-x text-danger" title="{{ __('messages.inactive') }}"></i>
                                        @endif
                                    </div>
                                </td>

                                <td style="width: 5%">
                                    <!-- Actions: Edit & Delete -->
                                    <div class="d-flex gap-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('invoices.edit', $invoice->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="ti ti-pencil"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('invoices.delete', $invoice->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('post')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {!! $invoices->links('pagination::bootstrap-4') !!}
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle delete action
            $(document).on('click', '.delete-btn', function() {
                const form = $(this).closest('.delete-form');
                Swal.fire({
                    title: '{{ __('messages.are_you_sure_to_delete') }}',
                    text: '{{ __('messages.you_will_not_be_able_to_recover_this') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('messages.yes_delete_it') }}',
                    cancelButtonText: '{{ __('messages.no_cancel') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    <script>
        $('.switch__input').on('change', function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var invoice_id = $(this).data('id');
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/admin/invoices/changeInvoiceActivity/' + invoice_id,
                data: {
                    'is_active': status,
                    'invoice_id': invoice_id
                },
                success: function(data) {

                },
                beforeSend: () => {
                    $(this).parent().find('#loader').show();
                    $(this).parent().find('.switch__input').hide();
                },
                complete: () => {
                    $(this).parent().find('#loader').hide();
                    $(this).parent().show();
                },
            });

        });

        $(document).ajaxComplete(function() {
            // Hide image container
            //$("#loader").hide();
        });
    </script>
@endpush
