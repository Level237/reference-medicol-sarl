@php
    $unescape = fn (string $value): string => trim(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));

    $documentTitle = $unescape($__env->yieldContent('title', 'Équipements médicaux'));
    $brand = 'Référence Médico Sarl';

    if (! str_contains($documentTitle, $brand)) {
        $documentTitle .= ' | '.$brand;
    }

    $metaDescription = $unescape($__env->yieldContent(
        'meta_description',
        'Référence Médico Sarl fournit des équipements et appareils médicaux aux hôpitaux et aux cliniques.'
    ));
    $canonical = $unescape($__env->yieldContent('canonical'));

    if ($canonical === '') {
        $canonical = url()->current();
    }

    $robots = $unescape($__env->yieldContent('robots', 'index, follow'));
    $ogType = $unescape($__env->yieldContent('og_type', 'website'));
    $ogImage = $unescape($__env->yieldContent('og_image', asset('assets/images/logo.png')));
    $ogImageAlt = $unescape($__env->yieldContent('og_image_alt', $documentTitle));
    $ogImageWidth = $unescape($__env->yieldContent('og_image_width'));
    $ogImageHeight = $unescape($__env->yieldContent('og_image_height'));

    if ($ogImage !== '' && ! str_starts_with($ogImage, 'http://') && ! str_starts_with($ogImage, 'https://')) {
        $ogImage = url($ogImage);
    }

    $metaDescription = trim(preg_replace('/\s+/u', ' ', strip_tags($metaDescription)) ?? '');
@endphp
<title>{{ $documentTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<link rel="canonical" href="{{ $canonical }}">
<meta name="robots" content="{{ $robots }}">
<meta property="og:site_name" content="{{ $brand }}">
<meta property="og:locale" content="fr_FR">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:title" content="{{ $documentTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
@if($ogImageAlt !== '')
<meta property="og:image:alt" content="{{ $ogImageAlt }}">
@endif
@if($ogImageWidth !== '')
<meta property="og:image:width" content="{{ $ogImageWidth }}">
@endif
@if($ogImageHeight !== '')
<meta property="og:image:height" content="{{ $ogImageHeight }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $documentTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">
