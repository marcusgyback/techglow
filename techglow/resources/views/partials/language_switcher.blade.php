<div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
    @foreach($available_locales as $locale => $name)
        @if($locale === $current_locale)
            <span class="ml-2 mr-2 text-gray-700">{{ $name }}</span>
        @else
            <a class="ml-1 underline ml-2 mr-2" href="i18n/{{ $locale }}">
                <span>{{ $name }}</span>
            </a>
        @endif
    @endforeach
</div>
