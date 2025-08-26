@extends('layoutmodule::main')

@section('title')
    {{ __('messages.invoices') }}
@endsection

@push('styles')
@endpush

@section('content')
    <div class="card-header">
        <h4>{{ __('messages.edit_invoice') }}</h4>
    </div>
    <form class="" method="POST" action='{{ route('invoices.update', $invoice->id) }}' enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $invoice->id }}">
        <div class="card-body">
            <div class="row mb-3">

                <div class="col-lg-2">
                    <label class="form-label" for="inv_date">{{ __('messages.invoice_date') }} <span
                            class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="inv_date" name="inv_date"
                        value="{{ old('inv_date', $invoice->inv_date) }}" placeholder="{{ __('messages.invoice_date') }}">
                </div>

                <div class="col-lg-2">
                    <label class="form-label" for="payment_method">{{ __('messages.payment_method') }}</label>
                    <select class="form-select" id="payment_method" name="payment_method">
                        @foreach ($payment_methods as $method)
                            <option value="{{ $method }}"
                                {{ old('payment_method', $invoice->payment_method) == $method ? 'selected' : '' }}>
                                {{ $method }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- <div class="row mb-3">
                <div class="col-lg-6">
                    <label class="form-label" for="name">{{ __('messages.name') }} <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $invoice->name) }}" placeholder="{{ __('messages.name') }}">
                </div>
            </div> --}}

            <div class="row mb-3">
                <div class="col-lg-6">
                    <label class="form-label" for="inv_for">{{ __('messages.invoice_for') }} <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="inv_for" name="inv_for"
                        value="{{ old('inv_for', $invoice->inv_for) }}" placeholder="{{ __('messages.invoice_for') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-2">
                    <label class="form-label"
                        for="inv_discount_per">{{ __('messages.invoice_discount_percentage') }}</label>
                    <input type="number" step="0.01" class="form-control" id="inv_discount_per" name="inv_discount_per"
                        value="{{ old('inv_discount_per', $invoice->inv_discount_per) }}"
                        placeholder="{{ __('messages.invoice_discount_percentage') }}">
                </div>
                <div class="col-lg-2">
                    <label class="form-label" for="tax_vat_per">{{ __('messages.tax_vat_percentage') }}</label>
                    <input type="number" step="0.01" class="form-control" id="tax_vat_per" name="tax_vat_per"
                        value="{{ old('tax_vat_per', $invoice->tax_vat_per) }}"
                        placeholder="{{ __('messages.tax_vat_percentage') }}">
                </div>
                <div class="col-lg-2">
                    <label class="form-label"
                        for="tax_withdrawal_per">{{ __('messages.tax_withdrawal_percentage') }}</label>
                    <input type="number" step="0.01" class="form-control" id="tax_withdrawal_per"
                        name="tax_withdrawal_per" value="{{ old('tax_withdrawal_per', $invoice->tax_withdrawal_per) }}"
                        placeholder="{{ __('messages.tax_withdrawal_percentage') }}">
                </div>
            </div>
        </div>
        <div class="card-header">
            <h4>{{ __('messages.invoice_items') }}</h4>
        </div>
       <div class="card-body">
            <div id="invoice-items-list">
                <!-- Item blocks will be added here -->
                @php $itemIndex = 0; @endphp
                @if(old('inv_items'))
                    @foreach(old('inv_items') as $item)
                        <div class="border rounded p-3 mb-2 position-relative invoice-item-block">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('messages.item') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_name]" class="form-control" required value="{{ $item['item_name'] ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('messages.item_description') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_desc]" class="form-control" value="{{ $item['item_desc'] ?? '' }}">
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-1">
                                    <label class="form-label">{{ __('messages.quantity') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_qty]" type="number" min="1" class="form-control item-qty" required value="{{ $item['item_qty'] ?? 1 }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('messages.unit_amount') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_unit_amount]" type="number" min="0" class="form-control item-unit-amount" required value="{{ $item['item_unit_amount'] ?? 0 }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">{{ __('messages.discount_percentage') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_discount_per]" type="number" min="0" class="form-control item-discount-per" value="{{ $item['item_discount_per'] ?? 0 }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('messages.discount_amount') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_discount]" type="number" min="0" class="form-control item-discount" value="{{ $item['item_discount'] ?? 0 }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label"><b>{{ __('messages.total_amount') }}</b></label>
                                    <input name="inv_items[{{ $itemIndex }}][item_total_amount]" type="number" min="0" class="form-control item-total-amount" required readonly value="{{ $item['item_total_amount'] ?? 0 }}">
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.border').remove()">{{ __('messages.remove') }}</button>
                                </div>
                            </div>
                        </div>
                        @php $itemIndex++; @endphp
                    @endforeach
                @else
                    @foreach($invoice->invoiceItems as $item)
                        <div class="border rounded p-3 mb-2 position-relative invoice-item-block">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('messages.item') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_name]" class="form-control" required value="{{ $item->item_name }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('messages.item_description') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_desc]" class="form-control" value="{{ $item->item_desc }}">
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-1">
                                    <label class="form-label">{{ __('messages.quantity') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_qty]" type="number" min="1" class="form-control item-qty" required value="{{ $item->item_qty }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('messages.unit_amount') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_unit_amount]" type="number" min="0" class="form-control item-unit-amount" required value="{{ $item->item_unit_amount }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">{{ __('messages.discount_percentage') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_discount_per]" type="number" step="0.01" min="0" class="form-control item-discount-per" value="{{ $item->item_discount_per }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('messages.discount_amount') }}</label>
                                    <input name="inv_items[{{ $itemIndex }}][item_discount]" type="number" step="0.01" min="0" class="form-control item-discount" value="{{ $item->item_discount }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label"><b>{{ __('messages.total_amount') }}</b></label>
                                    <input name="inv_items[{{ $itemIndex }}][item_total_amount]" type="number" min="0" class="form-control item-total-amount" required readonly value="{{ $item->item_total_amount }}">
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.border').remove()">{{ __('messages.remove') }}</button>
                                </div>
                            </div>
                        </div>
                        @php $itemIndex++; @endphp
                    @endforeach
                @endif
            </div>
            <button type="button" class="btn btn-success mt-2" id="add-item-btn">+ {{ __('messages.add_item') }}</button>
        </div>


        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary me-2"> {{ __('messages.save') }} </button>
            {{-- <button class="btn btn-secondary">Clear</button> --}}
        </div>
    </form>
    @push('scripts')
        <script>
            // Set itemIndex to last rendered item
            let itemIndex = {{ isset($itemIndex) ? $itemIndex : 0 }};
            document.getElementById('add-item-btn').addEventListener('click', function() {
                const list = document.getElementById('invoice-items-list');
                const itemDiv = document.createElement('div');
                itemDiv.className = 'border rounded p-3 mb-2 position-relative';
                itemDiv.innerHTML = `
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('messages.item') }}</label>
                            <input name="inv_items[${itemIndex}][item_name]" class="form-control" required>
                        </div> 
                        <div class="col-md-4">
                            <label class="form-label">{{ __('messages.item_description') }}</label>
                            <input name="inv_items[${itemIndex}][item_desc]" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-1">
                            <label class="form-label">{{ __('messages.quantity') }}</label>
                            <input name="inv_items[${itemIndex}][item_qty]" type="number" min="1" class="form-control item-qty" required value="1">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('messages.unit_amount') }}</label>
                            <input name="inv_items[${itemIndex}][item_unit_amount]" type="number" min="0" class="form-control item-unit-amount" required value="0">
                        </div> 
                        <div class="col-md-1">
                            <label class="form-label">{{ __('messages.discount_percentage') }}</label>
                            <input name="inv_items[${itemIndex}][item_discount_per]" type="number" step="0.01" min="0" class="form-control item-discount-per" value="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('messages.discount_amount') }}</label>
                            <input name="inv_items[${itemIndex}][item_discount]" type="number" step="0.01" min="0" class="form-control item-discount" value="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><b>{{ __('messages.total_amount') }}</b></label>
                            <input name="inv_items[${itemIndex}][item_total_amount]" type="number" min="0" class="form-control item-total-amount" required readonly value="0">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-1 d-flex align-items-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.border').remove()">{{ __('messages.remove') }}</button>
                        </div>
                    </div>
                `;
                list.appendChild(itemDiv);

                // Add auto calculation logic
                const qtyInput = itemDiv.querySelector('.item-qty');
                const unitAmountInput = itemDiv.querySelector('.item-unit-amount');
                const discountPerInput = itemDiv.querySelector('.item-discount-per');
                const discountInput = itemDiv.querySelector('.item-discount');
                const totalAmountInput = itemDiv.querySelector('.item-total-amount');

                function setDiscountFieldsState() {
                    const qty = parseFloat(qtyInput.value) || 0;
                    const unitAmount = parseFloat(unitAmountInput.value) || 0;
                    const enable = qty > 0 && unitAmount > 0;
                    discountPerInput.disabled = !enable;
                    discountInput.disabled = !enable;
                }

                function recalculateFromPer() {
                    setDiscountFieldsState();
                    const qty = parseFloat(qtyInput.value) || 1;
                    const unitAmount = parseFloat(unitAmountInput.value) || 0;
                    const discountPer = parseFloat(discountPerInput.value) || 0;
                    const subtotal = qty * unitAmount;
                    const discount = subtotal * (discountPer / 100);
                    discountInput.value = discount.toFixed(2);
                    totalAmountInput.value = (subtotal - discount).toFixed(2);
                }

                function recalculateFromAmount() {
                    setDiscountFieldsState();
                    const qty = parseFloat(qtyInput.value) || 1;
                    const unitAmount = parseFloat(unitAmountInput.value) || 0;
                    const discount = parseFloat(discountInput.value) || 0;
                    const subtotal = qty * unitAmount;
                    let discountPer = 0;
                    if (subtotal > 0) {
                        discountPer = (discount / subtotal) * 100;
                    }
                    discountPerInput.value = discountPer.toFixed(2);
                    totalAmountInput.value = (subtotal - discount).toFixed(2);
                }

                qtyInput.addEventListener('input', function() {
                    recalculateFromPer();
                });
                unitAmountInput.addEventListener('input', function() {
                    recalculateFromPer();
                });
                discountPerInput.addEventListener('input', function() {
                    recalculateFromPer();
                });
                discountInput.addEventListener('input', function() {
                    recalculateFromAmount();
                });
                // Initial calculation
                recalculateFromPer();
                itemIndex++;
            });

            // On page load, auto-activate JS logic for old items
            window.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.invoice-item-block').forEach(function(itemDiv) {
                    const qtyInput = itemDiv.querySelector('.item-qty');
                    const unitAmountInput = itemDiv.querySelector('.item-unit-amount');
                    const discountPerInput = itemDiv.querySelector('.item-discount-per');
                    const discountInput = itemDiv.querySelector('.item-discount');
                    const totalAmountInput = itemDiv.querySelector('.item-total-amount');

                    function setDiscountFieldsState() {
                        const qty = parseFloat(qtyInput.value) || 0;
                        const unitAmount = parseFloat(unitAmountInput.value) || 0;
                        const enable = qty > 0 && unitAmount > 0;
                        discountPerInput.disabled = !enable;
                        discountInput.disabled = !enable;
                    }

                    function recalculateFromPer() {
                        setDiscountFieldsState();
                        const qty = parseFloat(qtyInput.value) || 1;
                        const unitAmount = parseFloat(unitAmountInput.value) || 0;
                        const discountPer = parseFloat(discountPerInput.value) || 0;
                        const subtotal = qty * unitAmount;
                        const discount = subtotal * (discountPer / 100);
                        discountInput.value = discount.toFixed(2);
                        totalAmountInput.value = (subtotal - discount).toFixed(2);
                    }

                    function recalculateFromAmount() {
                        setDiscountFieldsState();
                        const qty = parseFloat(qtyInput.value) || 1;
                        const unitAmount = parseFloat(unitAmountInput.value) || 0;
                        const discount = parseFloat(discountInput.value) || 0;
                        const subtotal = qty * unitAmount;
                        let discountPer = 0;
                        if (subtotal > 0) {
                            discountPer = (discount / subtotal) * 100;
                        }
                        discountPerInput.value = discountPer.toFixed(2);
                        totalAmountInput.value = (subtotal - discount).toFixed(2);
                    }

                    qtyInput.addEventListener('input', function() {
                        recalculateFromPer();
                    });
                    unitAmountInput.addEventListener('input', function() {
                        recalculateFromPer();
                    });
                    discountPerInput.addEventListener('input', function() {
                        recalculateFromPer();
                    });
                    discountInput.addEventListener('input', function() {
                        recalculateFromAmount();
                    });
                    // Initial calculation
                    recalculateFromPer();
                });
            });
        </script>
    @endpush
@endsection
