@extends('layoutmodule::main')

@section('title')
    {{ __('messages.invoices') }}
@endsection

@push('styles')
@endpush

@section('content')
    <div class="card-header">
        <h4>{{ __('messages.update_invoice') }}</h4>
    </div>
    <form class="" method="POST" action='{{ route('invoices.update', $invoice->id) }}' enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $invoice->id }}">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-6">
                    <label class="form-label" for="name">{{ __('messages.name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $invoice->name) }}" placeholder="{{ __('messages.name') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="country">{{ __('messages.country') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="country" name="country"
                            value="{{ old('country', $invoice->country) }}" placeholder="{{ __('messages.country') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="hotel">{{ __('messages.hotel') }}</label>
                        <input type="text" class="form-control" id="hotel" name="hotel"
                            value="{{ old('hotel', $invoice->hotel) }}" placeholder="{{ __('messages.hotel') }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="hotel_link">{{ __('messages.hotel_link') }}</label>
                        <input type="text" class="form-control" id="hotel_link" name="hotel_link"
                            value="{{ old('hotel_link', $invoice->hotel_link) }}"
                            placeholder="{{ __('messages.hotel_link') }}">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="price_1w">{{ __('messages.price_one_week') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_1w" name="price_1w"
                            value="{{ old('price_1w', $invoice->price_1w) }}"
                            placeholder="{{ __('messages.price_one_week') }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="price_2w">{{ __('messages.price_two_weeks') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_2w" name="price_2w"
                            value="{{ old('price_2w', $invoice->price_2w) }}"
                            placeholder="{{ __('messages.price_two_weeks') }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="price_3w">{{ __('messages.price_three_weeks') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_3w" name="price_3w"
                            value="{{ old('price_3w', $invoice->price_3w) }}"
                            placeholder="{{ __('messages.price_three_weeks') }}">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="price_4w">{{ __('messages.price_four_weeks') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_4w" name="price_4w"
                            value="{{ old('price_4w', $invoice->price_4w) }}"
                            placeholder="{{ __('messages.price_four_weeks') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="price_8w">{{ __('messages.price_eight_weeks') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_8w" name="price_8w"
                            value="{{ old('price_8w', $invoice->price_8w) }}"
                            placeholder="{{ __('messages.price_eight_weeks') }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label"
                            for="price_3m">{{ __('messages.price_three_months') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_3m" name="price_3m"
                            value="{{ old('price_3m', $invoice->price_3m) }}"
                            placeholder="{{ __('messages.price_three_months') }}">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="price_6m">{{ __('messages.price_six_months') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_6m" name="price_6m"
                            value="{{ old('price_6m', $invoice->price_6m) }}"
                            placeholder="{{ __('messages.price_six_months') }}">
                    </div>
                </div>

                <div class="col-lg-3 d-none">
                    <div class="form-group">
                        <label class="form-label" for="price_9m">{{ __('messages.price_nine_months') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_9m" name="price_9m"
                            value="{{ old('price_9m', $invoice->price_9m) }}"
                            placeholder="{{ __('messages.price_nine_months') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3 d-none">
                <div class="col-lg-3 d-none">
                    <div class="form-group">
                        <label class="form-label" for="price_1y">{{ __('messages.price_one_year') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_1y" name="price_1y"
                            value="{{ old('price_1y', $invoice->price_1y) }}"
                            placeholder="{{ __('messages.price_one_year') }}">
                    </div>
                </div>

                <div class="col-lg-3 d-none">
                    <div class="form-group">
                        <label class="form-label" for="price_2y">{{ __('messages.price_two_years') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_2y" name="price_2y"
                            value="{{ old('price_2y', $invoice->price_2y) }}"
                            placeholder="{{ __('messages.price_two_years') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label" for="week_start">{{ __('messages.week_start') }} <span class="text-danger">*</span></label>
                        <select class="form-control" id="week_start" name="week_start">
                            @foreach($days as $d => $day)
                                <option value="{{ $d }}" {{ old('week_start', $invoice->week_start) == $d ? 'selected' : '' }}>
                                    {{ __($day) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="is_active">{{ __('messages.is_active') }}</label>
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                            {{ old('is_active', $invoice->is_active) ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="image">{{ __('messages.image') }} <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="image" name="image"
                            value="{{ old('image', $invoice->image) }}">
                    </div>
                </div>
                <div class="col-lg-2">
                    @if ($invoice->image)
                        <img src="{{ $invoice->imagePath }}" alt="{{ $invoice->name }}" class="img-fluid mt-2"
                            style="max-width: 100px; max-height: 100px;">
                    @endif
                </div>
            </div>

        </div>


        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary me-2"> {{ __('messages.save') }} </button>
            {{-- <button class="btn btn-secondary">Clear</button> --}}
        </div>
    </form>

    @push('scripts')
    @endpush
@endsection
