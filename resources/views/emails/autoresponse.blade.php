@component('mail::message')

Dear {{ $name }},
<br>

## Thank you for contacting {{ config('app.name') }}.

You should expect our response within 24 hours (Working day).

In case of emergency, Please feel free to call us.

<br>
<br>
Sincerely,

Support Team <br>
{{ config('app.name') }}<br>
Mobile No (Viber, WhatsApp): +977 9841816439<br>
[{{ config('app.url') }}]({{ config('app.url') }})
@endcomponent

