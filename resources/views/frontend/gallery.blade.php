@extends('layouts.guest')

@section('title', 'Gallery - IKICB')
@section('description', 'Browse our gallery of cosmetology and bridal training at IKICB.')
@section('keywords', 'IKICB gallery, cosmetology, bridal, training photos')

@section('content')

<!-- Hero Section - Clean Minimal -->
<div style="position: relative; background: #ffffff; padding: 48px 0 36px 0; border-bottom: 1px solid #f0f0f0; overflow: hidden;">

    <!-- Subtle floating dots -->
    <div style="position: absolute; inset: 0; pointer-events: none;">
        <div style="position: absolute; top: 16px; left: 8%; width: 6px; height: 6px; background: #eab308; border-radius: 50%; opacity: 0.3; animation: floatDot 4s ease-in-out infinite;"></div>
        <div style="position: absolute; top: 36px; right: 12%; width: 4px; height: 4px; background: #eab308; border-radius: 50%; opacity: 0.2; animation: floatDot 5.5s ease-in-out infinite 1s;"></div>
        <div style="position: absolute; bottom: 18px; left: 22%; width: 5px; height: 5px; background: #d97706; border-radius: 50%; opacity: 0.18; animation: floatDot 6s ease-in-out infinite 0.5s;"></div>
        <div style="position: absolute; bottom: 12px; right: 26%; width: 4px; height: 4px; background: #eab308; border-radius: 50%; opacity: 0.15; animation: floatDot 4.5s ease-in-out infinite 2s;"></div>
    </div>

    <div style="position: relative; max-width: 1280px; margin: 0 auto; padding: 0 24px; text-align: center;">

        <!-- Thin line accent -->
        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 14px;">
            <div style="width: 28px; height: 1.5px; background: linear-gradient(to right, transparent, #eab308);"></div>
            <span style="font-size: 11px; font-weight: 700; color: #b45309; letter-spacing: 0.18em; text-transform: uppercase;">Our Gallery</span>
            <div style="width: 28px; height: 1.5px; background: linear-gradient(to left, transparent, #eab308);"></div>
        </div>

        <h1 style="font-size: clamp(1.9rem, 4.5vw, 3rem); font-weight: 900; color: #111827; margin: 0 0 8px 0; letter-spacing: -0.03em; line-height: 1.1; animation: heroFadeUp 0.6s ease both;">
            Gallery
        </h1>

        <p style="font-size: 0.95rem; color: #9ca3af; max-width: 380px; margin: 0 auto; line-height: 1.7; font-weight: 400; animation: heroFadeUp 0.6s ease 0.12s both;">
            Explore our students' work and campus moments
        </p>

    </div>
</div>

<!-- Gallery Section -->
<section style="padding: 64px 0; background: #f9fafb; min-height: 60vh;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">

        @if($galleries->isEmpty())
            <div style="text-align: center; padding: 80px 0;">
                <div style="width: 96px; height: 96px; background: #fef9c3; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <svg style="width: 48px; height: 48px; color: #eab308;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p style="font-size: 1.2rem; color: #6b7280; font-weight: 600;">No gallery images yet.</p>
            </div>
        @else

            <!-- Category Filter Tabs -->
            <div id="category-tabs" style="display: flex; flex-wrap: nowrap; gap: 8px; justify-content: flex-start; margin-bottom: 40px; overflow-x: auto; overflow-y: hidden; padding: 6px 4px 12px 4px; -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none;">
            <style>#category-tabs::-webkit-scrollbar { display: none; }</style>
                <button
                    onclick="filterCategory('all')"
                    data-category="all"
                    id="btn-all"
                    style="padding: 8px 22px; border-radius: 999px; font-weight: 700; font-size: 13px; border: 2px solid #eab308; background: #eab308; color: #111827; cursor: pointer; transition: all 0.2s; letter-spacing: 0.03em; white-space: nowrap; flex-shrink: 0;">
                    All
                </button>
                @foreach($galleries->keys() as $category)
                    <button
                        onclick="filterCategory('{{ Str::slug($category) }}')"
                        data-category="{{ Str::slug($category) }}"
                        id="btn-{{ Str::slug($category) }}"
                        style="padding: 8px 22px; border-radius: 999px; font-weight: 700; font-size: 13px; border: 2px solid #e5e7eb; background: #ffffff; color: #6b7280; cursor: pointer; transition: all 0.2s; letter-spacing: 0.03em; white-space: nowrap; flex-shrink: 0;">
                        {{ $category }}
                    </button>
                @endforeach
            </div>

            <!-- Images Grid by Category -->
            @foreach($galleries as $category => $images)
                <div class="category-section" data-section="{{ Str::slug($category) }}" style="margin-bottom: 56px;">

                    <!-- Category Header -->
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 20px;">
                        <h2 style="font-size: 1.35rem; font-weight: 900; color: #111827; margin: 0; letter-spacing: -0.01em;">{{ $category }}</h2>
                        <span style="padding: 3px 12px; background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 700; border-radius: 999px; letter-spacing: 0.05em; text-transform: uppercase;">
                            {{ $images->count() }} {{ Str::plural('photo', $images->count()) }}
                        </span>
                        <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                    </div>

                    <!-- Images Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px;">
                        @foreach($images as $item)
                            <div
                                class="gallery-card"
                                onclick="openLightbox('{{ Storage::url($item->image_path) }}', '{{ $category }}')"
                                style="
                                    position: relative;
                                    aspect-ratio: 1 / 1;
                                    border-radius: 16px;
                                    overflow: hidden;
                                    cursor: pointer;
                                    box-shadow: 0 2px 12px rgba(0,0,0,0.10);
                                    transition: box-shadow 0.3s, transform 0.3s;
                                    background: #e5e7eb;
                                ">

                                <!-- Blurred background layer -->
                                <img
                                    src="{{ Storage::url($item->image_path) }}"
                                    alt="{{ $category }}"
                                    class="gallery-blur-bg"
                                    style="
                                        position: absolute;
                                        inset: 0;
                                        width: 100%;
                                        height: 100%;
                                        object-fit: cover;
                                        filter: blur(0px) brightness(1);
                                        transform: scale(1);
                                        transition: filter 0.4s ease, transform 0.4s ease;
                                        z-index: 1;
                                    "
                                    aria-hidden="true">

                                <!-- Main image (zooms on hover) -->
                                <img
                                    src="{{ Storage::url($item->image_path) }}"
                                    alt="{{ $category }}"
                                    class="gallery-main-img"
                                    style="
                                        position: absolute;
                                        inset: 0;
                                        width: 100%;
                                        height: 100%;
                                        object-fit: cover;
                                        transform: scale(1);
                                        transition: transform 0.45s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                                        z-index: 2;
                                    ">

                                <!-- Dark overlay -->
                                <div
                                    class="gallery-overlay"
                                    style="
                                        position: absolute;
                                        inset: 0;
                                        background: rgba(0,0,0,0);
                                        transition: background 0.35s ease;
                                        z-index: 3;
                                        display: flex;
                                        align-items: flex-end;
                                        padding: 14px;
                                    ">
                                    <!-- Category Label (hover only) -->
                                    <span
                                        class="gallery-label"
                                        style="
                                            display: inline-block;
                                            background: rgba(234,179,8,0.95);
                                            color: #111827;
                                            font-size: 12px;
                                            font-weight: 800;
                                            padding: 4px 12px;
                                            border-radius: 999px;
                                            letter-spacing: 0.04em;
                                            opacity: 0;
                                            transform: translateY(8px);
                                            transition: opacity 0.3s ease, transform 0.3s ease;
                                            text-transform: uppercase;
                                        ">
                                        {{ $category }}
                                    </span>
                                </div>

                                <!-- Zoom/search icon -->
                                <div
                                    class="gallery-icon"
                                    style="
                                        position: absolute;
                                        top: 12px;
                                        right: 12px;
                                        width: 36px;
                                        height: 36px;
                                        background: rgba(255,255,255,0.92);
                                        border-radius: 50%;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        opacity: 0;
                                        transform: scale(0.7);
                                        transition: opacity 0.3s ease, transform 0.3s ease;
                                        z-index: 4;
                                    ">
                                    <svg style="width: 18px; height: 18px; color: #111827;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        @endif
    </div>
</section>

<!-- Lightbox -->
<div
    id="lightbox"
    onclick="closeLightbox(event)"
    style="
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.92);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 16px;
        backdrop-filter: blur(8px);
    ">

    <button
        onclick="closeLightbox()"
        style="
            position: absolute;
            top: 18px;
            right: 18px;
            background: rgba(255,255,255,0.10);
            border: none;
            color: #ffffff;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            z-index: 10;
        "
        onmouseover="this.style.background='rgba(234,179,8,0.7)'"
        onmouseout="this.style.background='rgba(255,255,255,0.10)'">
        <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <div onclick="event.stopPropagation()" style="max-width: 860px; width: 100%;">
        <img
            id="lightbox-img"
            src=""
            alt=""
            style="
                width: 100%;
                max-height: 80vh;
                object-fit: contain;
                border-radius: 14px;
                box-shadow: 0 32px 80px rgba(0,0,0,0.6);
                display: block;
            ">
        <p
            id="lightbox-caption"
            style="
                text-align: center;
                color: #ffffff;
                font-size: 13px;
                font-weight: 600;
                margin-top: 14px;
                opacity: 0.65;
                letter-spacing: 0.06em;
                text-transform: uppercase;
            ">
        </p>
    </div>
</div>

<style>
    /* ── Filter tabs responsive ── */
    #category-tabs {
        justify-content: center;
    }
    @media (max-width: 768px) {
        #category-tabs {
            justify-content: flex-start !important;
            /* fade right edge hint */
            -webkit-mask-image: linear-gradient(to right, black 85%, transparent 100%);
            mask-image: linear-gradient(to right, black 85%, transparent 100%);
        }
    }

    /* ── Hero animations ── */
    @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes floatDot {
        0%, 100% { transform: translateY(0px); }
        50%       { transform: translateY(-8px); }
    }

    /* ── Card entrance animation ── */
    @keyframes cardEntrance {
        from { opacity: 0; transform: translateY(22px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0)   scale(1); }
    }
    .gallery-card {
        animation: cardEntrance 0.5s ease both;
    }
    /* stagger each card */
    .gallery-card:nth-child(1)  { animation-delay: 0.05s; }
    .gallery-card:nth-child(2)  { animation-delay: 0.10s; }
    .gallery-card:nth-child(3)  { animation-delay: 0.15s; }
    .gallery-card:nth-child(4)  { animation-delay: 0.20s; }
    .gallery-card:nth-child(5)  { animation-delay: 0.25s; }
    .gallery-card:nth-child(6)  { animation-delay: 0.30s; }
    .gallery-card:nth-child(7)  { animation-delay: 0.35s; }
    .gallery-card:nth-child(8)  { animation-delay: 0.40s; }

    /* ── Hover: zoom + blur ── */
    .gallery-card:hover .gallery-main-img {
        transform: scale(1.13) !important;
    }
    .gallery-card:hover .gallery-blur-bg {
        filter: blur(16px) brightness(0.65) !important;
        transform: scale(1.20) !important;
    }
    .gallery-card:hover .gallery-overlay {
        background: rgba(0,0,0,0.25) !important;
    }
    .gallery-card:hover .gallery-label {
        opacity: 1 !important;
        transform: translateY(0px) !important;
    }
    .gallery-card:hover .gallery-icon {
        opacity: 1 !important;
        transform: scale(1) !important;
    }
    .gallery-card:hover {
        box-shadow: 0 16px 48px rgba(0,0,0,0.20) !important;
        transform: translateY(-4px) scale(1.01) !important;
    }

    /* ── Lightbox image pop-in ── */
    @keyframes lightboxPop {
        from { opacity: 0; transform: scale(0.93); }
        to   { opacity: 1; transform: scale(1); }
    }
    #lightbox-img {
        animation: lightboxPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        div[style*="grid-template-columns"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
</style>

<script>
function filterCategory(cat) {
    // Reset all buttons
    document.querySelectorAll('[id^="btn-"]').forEach(btn => {
        btn.style.background = '#ffffff';
        btn.style.borderColor = '#e5e7eb';
        btn.style.color = '#6b7280';
    });

    // Activate selected button
    const activeBtn = document.getElementById('btn-' + cat);
    if (activeBtn) {
        activeBtn.style.background = '#eab308';
        activeBtn.style.borderColor = '#eab308';
        activeBtn.style.color = '#111827';
    }

    // Show/hide sections
    document.querySelectorAll('.category-section').forEach(section => {
        if (cat === 'all' || section.dataset.section === cat) {
            section.style.display = '';
        } else {
            section.style.display = 'none';
        }
    });
}

function openLightbox(src, caption) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-caption').textContent = caption;
    const lb = document.getElementById('lightbox');
    lb.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox(event) {
    const lb = document.getElementById('lightbox');
    if (!event || event.target === lb) {
        lb.style.display = 'none';
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox();
});
</script>

@endsection