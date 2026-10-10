@props([
    'categories' => [],
    'selectedCategory' => '',
    'name' => 'category',
    'id' => null,
    'submitOnChange' => false,
])

@php
    $selectId = $id ?? $name.'-select';
@endphp

<div {{ $attributes->merge(['class' => 'relative']) }}>
    <label for="{{ $selectId }}" class="sr-only">Catégorie</label>
    <select
        id="{{ $selectId }}"
        name="{{ $name }}"
        @if($submitOnChange) onchange="this.form.submit()" @endif
        class="w-full appearance-none rounded-xl border border-[#e4e7ec] bg-[#fcfcfd] py-2 pl-3 pr-8 text-xs sm:text-sm text-[#1d2939] focus:border-[#029e55] focus:outline-none focus:ring-2 focus:ring-[#029e55]/20 cursor-pointer"
    >
        <option value="">Toutes les catégories</option>
        @foreach($categories as $cat)
            <option
                value="{{ $cat->slug }}"
                {{ $selectedCategory === $cat->slug || $selectedCategory == $cat->id ? 'selected' : '' }}
            >
                {{ $cat->name }}@if(isset($cat->products_count)) ({{ $cat->products_count }})@endif
            </option>
        @endforeach
    </select>
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-[#667085]">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 7" />
        </svg>
    </div>
</div>
