@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            DesignU
        @endcomponent
    @endslot

    {{-- Body --}}
    # Hello  {!! $user->name!!},<br>

    Welcome to DesignU! Please click on the following link to confirm your DesignU account:<br />
    @component('mail::button', ['url' =>  $user->activationUrl  ])
        Activate Your Email Account
    @endcomponent


    Thanks,

    {{-- Footer --}}
    @slot('footer')
    @component('mail::footer')
    &copy; 2018 All Copy right received
@endcomponent
@endslot
@endcomponent