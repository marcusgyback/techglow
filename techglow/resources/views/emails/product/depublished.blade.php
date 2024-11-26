<x-mail::message>
# Produkt inaktiverad
## {{$product->name}}

    {{ strip_tags($product->description)}}

<x-mail::button :url="$url">
    {{$product->name}}
</x-mail::button>

CRON,<br>
{{ config('app.name') }}
</x-mail::message>
