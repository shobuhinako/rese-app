@component('mail::message')
# お知らせ

{{ $message }}

@component('mail::button', ['url' => ''])
    Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
