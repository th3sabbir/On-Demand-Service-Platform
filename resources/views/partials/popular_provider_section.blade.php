<?php if($singlevendor=='off') { ?>

<section class="section pt-0 bg-white">
    <div class="container">
        <div class="provider-sec">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-header text-center">
                        <h2 class="mb-1">{{ __('Popular') }} <span
                                class="text-linear-primary">{{ __('Providers') }}</span></h2>
                        <p class="sub-title">
                            {{ __('Each listing is designed to be clear and concise, providing customers') }}
                        </p>
                    </div>
                </div>
            </div>
            @if(!empty($section['section_content']) && count($section['section_content']) > 0)

            <div class="row gx-0">
                @foreach($section['section_content'] as $provider)
                <div class="col-xl-3 col-lg-4 col-md-6 d-flex">
                    <div class="provider-item flex-fill">
                        @if (isset($provider['featured']) && $provider['featured'] == 1)
                            <div class="home-feature-text"><span>{{ __('featured') }}</span></div>
                        @endif
                        <div class="d-flex align-items-center ms-2">
                            <a href="/{{ $provider['user_slug'] ?? '' }}" data-provider-id="{{$provider['provider_id']}}"
                                class="provider-details-link avatar avatar-xl me-2">

                                @if(!empty($provider['profile_image']) && file_exists(public_path('storage/profile/' . $provider['profile_image'])))
                                <img src="{{ url('storage/profile/' . $provider['profile_image']) }}"
                                    alt="Profile Image" class="rounded-circle">
                                @else
                                <img src="{{ asset('assets/img/user-default.jpg') }}" alt="Default Image"
                                    class="rounded-circle">
                                @endif
                            </a>
                            <div>
                                <h6>
                                    <a href="/{{ $provider['user_slug'] ?? '' }}" data-provider-id="{{$provider['provider_id']}}"
                                        class="provider-details-link">
                                        {{ ucfirst(strtolower($provider['provider_name'] ?? 'No name')) }} </a>
                                    @if (isset($provider['badge']) && $provider['badge'] == 1)
                                        <span class="text-success ms-2"><i class="fa fa-check-circle"></i></span>
                                    @endif
                                </h6>
                                <p class="fs-14 mb-0">
                                    <i class="ti ti-star-filled text-warning me-1"></i>
                                    {{ number_format((float) ($provider['average_rating'] ?? 0), 1) }}
                                    ({{ $provider['total_ratings'] ?? 0 }} {{ __('Reviews') }})
                                </p>
                                <p class="mb-0">
                                    {{ $provider['total_products'] ?? 0 }} {{ __('Services') }}
                                    @if (isset($provider['hourly_rate']) && !empty($provider['hourly_rate']))
                                    , <span class="text-gray-9">{{$currency_details->symbol ?? '$'}}{{ $provider['hourly_rate'] }}/hr</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <div class="text-center view-all wow fadeInUp" data-wow-delay="0.2s">
                <a href="{{ route('user.providerlist') }}" class="btn btn-dark">{{ __('View All') }}<i
                        class="ti ti-arrow-right ms-2"></i></a>
            </div>
            @else
            <h6 class="text-center">{{ __('No popular providers available.') }}</h6>
            @endif
        </div>
    </div>
</section>
<?php } ?>