{{-- ============================================================
     Graduation Banner Section
     Include in your home page with: @include('partials.graduation-banner')
     Place in: resources/views/partials/graduation-banner.blade.php
     ============================================================ --}}

<!-- Graduation Banner Section -->
<section style="position: relative;  padding: 80px 0; overflow: hidden;">

    <!-- Background Image Layer -->
    <div style="position: absolute; inset: 0; z-index: 0;">
        <img
            src="{{ asset('images/temp/Banner.webp') }}"
            alt=""
            style="width: 100%; height: 100%; object-fit: cover; object-position: center top; opacity: 0.65; filter: grayscale(10%);"
            aria-hidden="true">
        <!-- Dark overlay for text readability -->
        <div style="position: absolute; inset: 0; background: rgba(10, 12, 22, 0.55);"></div>
        <!-- Bottom fade -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 120px; background: linear-gradient(to top, rgba(7,10,18,0.98), transparent);"></div>
    </div>



    <div style="position: relative; z-index: 2; max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 48px; justify-content: space-between;">

            <!-- Left: Text Content -->
            <div style="flex: 1; min-width: 280px; max-width: 600px;">

                <!-- Badge -->
                <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; border-radius: 999px; background: rgba(234,179,8,0.15); border: 1px solid rgba(234,179,8,0.35); margin-bottom: 22px;">
                    <span style="font-size: 14px;">🎓</span>
                    <span style="font-size: 11px; font-weight: 700; color: #eab308; letter-spacing: 0.14em; text-transform: uppercase;">Graduation Ceremony {{ date('Y') }}</span>
                </div>

                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 900; color: #ffffff; margin: 0 0 16px 0; line-height: 1.15; letter-spacing: -0.02em;">
                    Celebrating Our <span style="color: #eab308;">Graduates</span> of {{ date('Y') }}
                </h2>

                <p style="font-size: 1rem; color: #ffffff; line-height: 1.8; margin: 0 0 14px 0;">
                    We are proud to celebrate the achievements of our graduating class. This year's ceremony marks a milestone for our students who have completed their training in cosmetology and bridal artistry.
                </p>
                <p style="font-size: 1rem; color: #ffffff; line-height: 1.8; margin: 0 0 30px 0;">
                    Join us in honoring their dedication, hard work, and passion for beauty. The future is bright for every one of our graduates. 🌟
                </p>

                <!-- Stats row -->
                <div style="display: flex; flex-wrap: wrap; gap: 24px; margin-bottom: 32px;">
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; font-weight: 900; color: #eab308; line-height: 1;">50+</div>
                        <div style="font-size: 12px; color: #e5e7eb; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; margin-top: 4px;">Graduates</div>
                    </div>
                    <div style="width: 1px; background: rgba(255,255,255,0.08); align-self: stretch;"></div>
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; font-weight: 900; color: #eab308; line-height: 1;">{{ date('Y') }}</div>
                        <div style="font-size: 12px; color: #e5e7eb; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; margin-top: 4px;">Ceremony Year</div>
                    </div>
                    <div style="width: 1px; background: rgba(255,255,255,0.08); align-self: stretch;"></div>
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; font-weight: 900; color: #eab308; line-height: 1;">100%</div>
                        <div style="font-size: 12px; color: #e5e7eb; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; margin-top: 4px;">Dedication</div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">

                    <!-- WhatsApp button -->
                    <a href="https://wa.me/94751425425"
                       target="_blank"
                       rel="noopener noreferrer"
                       onmouseover="this.style.background='#16a34a'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(22,163,74,0.45)';"
                       onmouseout="this.style.background='#22c55e'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(22,163,74,0.35)';"
                       style="display: inline-flex; align-items: center; gap: 10px; padding: 13px 26px; background: #22c55e; color: #ffffff; font-weight: 800; font-size: 14px; border-radius: 999px; text-decoration: none; box-shadow: 0 4px 16px rgba(22,163,74,0.35); transition: all 0.25s ease; letter-spacing: 0.02em;">
                        <svg style="width: 20px; height: 20px; flex-shrink: 0;" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Contact on WhatsApp
                    </a>

                    <!-- Phone outlined button -->
                    <a href="https://wa.me/94751425425"
                       target="_blank"
                       rel="noopener noreferrer"
                       onmouseover="this.style.background='rgba(234,179,8,0.15)'; this.style.borderColor='#eab308'; this.style.color='#eab308'; this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(255,255,255,0.2)'; this.style.color='#ffffff'; this.style.transform='translateY(0)';"
                       style="display: inline-flex; align-items: center; gap: 8px; padding: 13px 26px; background: transparent; color: #ffffff; font-weight: 700; font-size: 14px; border-radius: 999px; text-decoration: none; border: 2px solid rgba(255,255,255,0.2); transition: all 0.25s ease; letter-spacing: 0.02em;">
                        <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"></path>
                        </svg>
                        +94 75 142 5425
                    </a>
                </div>
            </div>

            <!-- Right: Cards -->
            <div style="flex-shrink: 0; width: 280px; display: flex; flex-direction: column; gap: 14px;">

                <!-- Announcement card -->
                <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(234,179,8,0.25); border-radius: 20px; padding: 24px; backdrop-filter: blur(10px);">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #eab308, #d97706); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">🎓</div>
                        <div>
                            <div style="font-size: 13px; font-weight: 800; color: #ffffff; line-height: 1.3;">Graduation Ceremony</div>
                            <div style="font-size: 11px; color: #eab308; font-weight: 600; margin-top: 2px;">{{ date('Y') }} Batch</div>
                        </div>
                    </div>
                    <p style="font-size: 13px; color: #ffffff; line-height: 1.7; margin: 0 0 16px 0;">
                        Congratulations to all our graduates! Your journey at IKICB has been truly inspiring.
                    </p>
                    <div style="height: 1px; background: rgba(255,255,255,0.08); margin-bottom: 14px;"></div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; animation: gradPulse 2s infinite;"></div>
                        <span style="font-size: 12px; color: #e5e7eb; font-weight: 600;">Registrations Open Now</span>
                    </div>
                </div>

                <!-- Quick WhatsApp card -->
                <a href="https://wa.me/94751425425"
                   target="_blank"
                   rel="noopener noreferrer"
                   onmouseover="this.style.background='rgba(34,197,94,0.15)'; this.style.borderColor='rgba(34,197,94,0.5)';"
                   onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.borderColor='rgba(255,255,255,0.1)';"
                   style="display: flex; align-items: center; gap: 14px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 16px 20px; text-decoration: none; transition: all 0.25s ease;">
                    <div style="width: 42px; height: 42px; background: #22c55e; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 22px; height: 22px; color: white;" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight: 800; color: #ffffff;">Chat on WhatsApp</div>
                        <div style="font-size: 12px; color: #e5e7eb; margin-top: 2px;">+94 75 142 5425</div>
                    </div>
                    <svg style="width: 16px; height: 16px; color: #4b5563; margin-left: auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

            </div>
        </div>
    </div>
</section>

<style>
    @keyframes gradPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.4; transform: scale(1.5); }
    }
    /* Stack right card below text on small screens */
    @media (max-width: 768px) {
        .grad-right-col { width: 100% !important; }
    }
</style>