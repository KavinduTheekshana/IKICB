@extends('layouts.guest')

@section('title', 'Personal Information | IKICB')

@php
    $eduDefault  = [['institution' => '', 'qualification' => '', 'year' => '']];
    $workDefault = [['company' => '', 'position' => '', 'start_date' => '', 'end_date' => '', 'description' => '']];
    $emerDefault = [['name' => '', 'phone' => '', 'relationship' => '']];

    $eduData  = old('educational_qualifications',  $detail?->educational_qualifications  ?: $eduDefault);
    $workData = old('work_experience',             $detail?->work_experience             ?: $workDefault);
    $emerData = old('emergency_contacts',          $detail?->emergency_contacts          ?: $emerDefault);

    if (empty($eduData))  $eduData  = $eduDefault;
    if (empty($workData)) $workData = $workDefault;
    if (empty($emerData)) $emerData = $emerDefault;

    $existingImage = $detail?->image ? asset('storage/' . $detail->image) : '';
@endphp

@section('content')

<style>
.pi-header-inner,
.pi-nav-inner  { max-width:80rem; margin:0 auto; padding:0 16px; }
.pi-page-wrap  { background:#f3f4f6; min-height:100vh; padding:28px 16px 56px; }
.pi-inner      { max-width:80rem; margin:0 auto; }

@@media(min-width:640px){
    .pi-header-inner,
    .pi-nav-inner { padding:0 24px; }
    .pi-page-wrap { padding:28px 24px 56px; }
}
@@media(min-width:1024px){
    .pi-header-inner,
    .pi-nav-inner { padding:0 32px; }
    .pi-page-wrap { padding:28px 32px 56px; }
}

.pi-card      { background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; margin-bottom:16px; }
.pi-card-head { display:flex; align-items:center; gap:10px; padding:15px 22px; border-bottom:1px solid #f3f4f6; }
.pi-card-body { padding:22px; }

.pi-label {
    display:block; color:#6b7280; font-size:11px; font-weight:700;
    letter-spacing:.07em; text-transform:uppercase; margin-bottom:5px;
}
.pi-input {
    width:100%; padding:10px 13px; background:#f9fafb; border:1px solid #e5e7eb;
    border-radius:9px; font-size:13px; color:#111; outline:none;
    box-sizing:border-box; font-family:inherit; transition:border-color .15s;
}
.pi-input:focus { border-color:#111; }

.pi-row { padding:14px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:11px; margin-bottom:10px; }

.pi-grid-3    { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:16px; }
.pi-edu-grid  { display:grid; grid-template-columns:2fr 2fr 1fr 36px; gap:12px; align-items:end; }
.pi-work-grid { display:grid; grid-template-columns:1fr 1fr 1fr 1fr 36px; gap:12px; align-items:end; }
.pi-emer-grid { display:grid; grid-template-columns:1fr 1fr 1fr 36px; gap:12px; align-items:end; }

@@media(max-width:1023px){
    .pi-grid-3    { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .pi-work-grid { grid-template-columns:1fr 1fr 36px; }
}
@@media(max-width:639px){
    .pi-card-body { padding:16px; }
    .pi-grid-3    { grid-template-columns:minmax(0,1fr); }
    .pi-col-2     { grid-column:span 1 !important; }
    .pi-edu-grid,
    .pi-work-grid,
    .pi-emer-grid { grid-template-columns:minmax(0,1fr); }
    .pi-del-wrap  { justify-content:flex-end; }
}
@@media(min-width:640px){
    .pi-col-2    { grid-column:span 2; }
    .pi-del-wrap { align-items:flex-end; }
}

.pi-del-wrap { display:flex; }
.pi-del-btn {
    width:36px; height:36px; background:#f3f4f6; border:1px solid #e5e7eb;
    border-radius:8px; cursor:pointer; display:flex; align-items:center;
    justify-content:center; flex-shrink:0; transition:background .15s;
}
.pi-del-btn:hover { background:#111; }
.pi-del-btn:hover svg { stroke:#fff; }

.pi-add-btn {
    display:inline-flex; align-items:center; gap:7px; padding:9px 16px;
    background:#fff; border:1px solid #d1d5db; border-radius:9px;
    color:#374151; font-size:13px; font-weight:600; cursor:pointer; margin-top:4px;
}
</style>

{{-- ── TOP BAR ────────────────────────────────────────────── --}}
<div style="background:#000;padding:28px 0;">
    <div class="pi-header-inner" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <p style="color:#9ca3af;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin:0 0 4px;">Student Profile</p>
            <h1 style="color:#fff;font-size:26px;font-weight:900;margin:0;line-height:1.2;">Personal Information</h1>
        </div>
        <a href="{{ route('dashboard') }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:600;border-radius:12px;text-decoration:none;">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>
    </div>
</div>

{{-- ── NAV TABS ─────────────────────────────────────────────── --}}
<div style="background:#fff;border-bottom:1px solid #e5e7eb;position:sticky;top:80px;z-index:40;overflow-x:auto;">
    <div class="pi-nav-inner">
        <nav style="display:flex;min-width:max-content;overflow-x:auto;">
            @php
                $navItems = [
                    ['route' => route('dashboard'),               'label' => 'Overview',       'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => route('dashboard.my-courses'),    'label' => 'My Courses',     'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ['route' => route('submissions.index'),       'label' => 'My Submissions', 'icon' => 'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12'],
                    ['route' => route('dashboard.payments'),      'label' => 'Payments',       'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                    ['route' => route('dashboard.personal-info'), 'label' => 'Personal Info',  'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'active' => true],
                ];
            @endphp
            @foreach($navItems as $item)
                @php $active = !empty($item['active']); @endphp
                <a href="{{ $item['route'] }}"
                   style="display:inline-flex;align-items:center;gap:6px;padding:14px 4px;border-bottom:3px solid {{ $active ? '#eab308' : 'transparent' }};color:{{ $active ? '#ca8a04' : '#6b7280' }};font-weight:{{ $active ? '900' : '700' }};font-size:13px;text-decoration:none;margin-right:24px;white-space:nowrap;transition:color .15s;">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</div>

{{-- ── PAGE BODY ────────────────────────────────────────────── --}}
<div class="pi-page-wrap">
<div class="pi-inner">

    @if(session('success'))
    <div style="display:flex;align-items:center;gap:12px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:14px 18px;margin-bottom:20px;">
        <div style="width:26px;height:26px;background:#111;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="13" height="13" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        <span style="color:#111;font-weight:600;font-size:14px;">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div style="background:#fff;border:1px solid #fecaca;border-radius:12px;padding:14px 18px;margin-bottom:20px;">
        <p style="color:#b91c1c;font-weight:700;font-size:13px;margin:0 0 6px;">Please fix the following:</p>
        @foreach($errors->all() as $err)
            <p style="color:#dc2626;font-size:12px;margin:3px 0;">• {{ $err }}</p>
        @endforeach
    </div>
    @endif

    <form action="{{ route('dashboard.personal-info.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- ══ SECTION 1: PERSONAL INFORMATION ══ --}}
    <div class="pi-card">
        <div class="pi-card-head">
            <div style="width:26px;height:26px;background:#111;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="color:#fff;font-size:11px;font-weight:900;">1</span>
            </div>
            <h2 style="color:#111;font-size:12px;font-weight:800;letter-spacing:.09em;text-transform:uppercase;margin:0;">Personal Information</h2>
        </div>
        <div class="pi-card-body">

            {{-- Photo --}}
            <div style="display:flex;align-items:flex-start;gap:18px;margin-bottom:22px;flex-wrap:wrap;">
                <div style="width:76px;height:76px;border-radius:12px;border:2px solid #e5e7eb;background:#f9fafb;position:relative;overflow:hidden;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                    <img id="img-preview"
                         src="{{ $existingImage ?: '' }}"
                         style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;{{ $existingImage ? '' : 'display:none;' }}"
                         alt="Profile photo">
                    <svg id="img-placeholder"
                         width="30" height="30" fill="none" stroke="#d1d5db" viewBox="0 0 24 24"
                         style="{{ $existingImage ? 'display:none;' : '' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:200px;">
                    <p class="pi-label">Profile Photo</p>
                    <label style="display:flex;align-items:center;gap:10px;padding:11px 14px;background:#f9fafb;border:2px dashed #d1d5db;border-radius:10px;cursor:pointer;">
                        <svg width="17" height="17" fill="none" stroke="#9ca3af" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        <span style="color:#6b7280;font-size:13px;">Click to upload a photo</span>
                        <input type="file" id="image-input" name="image" accept="image/jpeg,image/png,image/webp" style="display:none;">
                    </label>
                    <p style="color:#9ca3af;font-size:11px;margin:5px 0 0;">JPG, PNG, WEBP — max 2 MB</p>
                    <p style="color:#6b7280;font-size:11px;margin:6px 0 0;line-height:1.5;border-left:3px solid #d1d5db;padding-left:8px;">
                        <strong style="color:#374151;">Formal application photo required:</strong> Face must be clearly visible, looking straight at the camera, with a plain or light background. Selfies, casual, or group photos are <strong style="color:#ef4444;">not accepted</strong>.
                    </p>
                    @error('image')<p style="color:#ef4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Fields --}}
            <div class="pi-grid-3">
                <div>
                    <label class="pi-label">Name with Initials <span style="color:#ef4444;text-transform:none;letter-spacing:0;font-weight:400;">*</span></label>
                    <input type="text" name="name_with_initials" value="{{ old('name_with_initials', $detail?->name_with_initials) }}" placeholder="e.g. T.K. Perera" class="pi-input">
                    @error('name_with_initials')<p style="color:#ef4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div class="pi-col-2">
                    <label class="pi-label">Full Name <span style="color:#ef4444;text-transform:none;letter-spacing:0;font-weight:400;">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name', $detail?->full_name) }}" placeholder="e.g. Nimal Perera" class="pi-input">
                    @error('full_name')<p style="color:#ef4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="pi-label">Date of Birth <span style="color:#ef4444;text-transform:none;letter-spacing:0;font-weight:400;">*</span></label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $detail?->date_of_birth?->format('Y-m-d')) }}" class="pi-input">
                    @error('date_of_birth')<p style="color:#ef4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="pi-label">Gender <span style="color:#ef4444;text-transform:none;letter-spacing:0;font-weight:400;">*</span></label>
                    <select name="gender" class="pi-input">
                        <option value="">Select gender</option>
                        <option value="male"   @selected(old('gender',$detail?->gender)==='male')>Male</option>
                        <option value="female" @selected(old('gender',$detail?->gender)==='female')>Female</option>
                        <option value="other"  @selected(old('gender',$detail?->gender)==='other')>Other</option>
                    </select>
                    @error('gender')<p style="color:#ef4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="pi-label">NIC / ID Number <span style="color:#ef4444;text-transform:none;letter-spacing:0;font-weight:400;">*</span></label>
                    <input type="text" name="id_number" value="{{ old('id_number', $detail?->id_number) }}" placeholder="e.g. 200012345678" class="pi-input">
                    @error('id_number')<p style="color:#ef4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="pi-label">Past School</label>
                    <input type="text" name="past_school" value="{{ old('past_school', $detail?->past_school) }}" placeholder="e.g. Nalanda College" class="pi-input">
                </div>
                <div>
                    <label class="pi-label">Email Address</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled
                           style="width:100%;padding:10px 13px;background:#f3f4f6;border:1px solid #e5e7eb;border-radius:9px;font-size:13px;color:#9ca3af;cursor:not-allowed;box-sizing:border-box;">
                </div>
                <div>
                    <label class="pi-label">Phone Number <span style="color:#ef4444;text-transform:none;letter-spacing:0;font-weight:400;">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $detail?->phone) }}" placeholder="e.g. 0771234567" class="pi-input">
                    @error('phone')<p style="color:#ef4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div style="grid-column: 1 / -1;">
                    <label class="pi-label">Permanent Address</label>
                    <textarea name="permanent_address" rows="3" placeholder="e.g. No. 25, Main Street, Colombo 05" class="pi-input" style="resize:vertical;">{{ old('permanent_address', $detail?->permanent_address) }}</textarea>
                    @error('permanent_address')<p style="color:#ef4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ══ SECTION 2: EDUCATIONAL QUALIFICATIONS ══ --}}
    <div class="pi-card">
        <div class="pi-card-head">
            <div style="width:26px;height:26px;background:#111;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="color:#fff;font-size:11px;font-weight:900;">2</span>
            </div>
            <h2 style="color:#111;font-size:12px;font-weight:800;letter-spacing:.09em;text-transform:uppercase;margin:0;">Educational Qualifications</h2>
        </div>
        <div class="pi-card-body">
            <div id="edu-list">
                @foreach($eduData as $i => $edu)
                <div class="pi-row edu-item">
                    <div class="pi-edu-grid">
                        <div>
                            <label class="pi-label">Institution / University</label>
                            <input type="text" name="educational_qualifications[{{ $i }}][institution]"
                                   value="{{ $edu['institution'] ?? '' }}"
                                   placeholder="e.g. IKICB, London School of Beauty" class="pi-input">
                        </div>
                        <div>
                            <label class="pi-label">Qualification / Degree</label>
                            <input type="text" name="educational_qualifications[{{ $i }}][qualification]"
                                   value="{{ $edu['qualification'] ?? '' }}"
                                   placeholder="e.g. Diploma in Cosmetology" class="pi-input">
                        </div>
                        <div>
                            <label class="pi-label">Year</label>
                            <input type="text" name="educational_qualifications[{{ $i }}][year]"
                                   value="{{ $edu['year'] ?? '' }}"
                                   placeholder="2022" class="pi-input">
                        </div>
                        <div class="pi-del-wrap">
                            <button type="button" class="pi-del-btn"
                                    onclick="removeRow(this,'edu-list','.edu-item','educational_qualifications')"
                                    title="Remove">
                                <svg width="13" height="13" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="pi-add-btn" onclick="addRow('edu')">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Qualification
            </button>
        </div>
    </div>

    {{-- ══ SECTION 3: WORK EXPERIENCE ══ --}}
    <div class="pi-card">
        <div class="pi-card-head">
            <div style="width:26px;height:26px;background:#111;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="color:#fff;font-size:11px;font-weight:900;">3</span>
            </div>
            <h2 style="color:#111;font-size:12px;font-weight:800;letter-spacing:.09em;text-transform:uppercase;margin:0;">Work Experience</h2>
        </div>
        <div class="pi-card-body">
            <div id="work-list">
                @foreach($workData as $i => $work)
                <div class="pi-row work-item">
                    <div class="pi-work-grid" style="margin-bottom:10px;">
                        <div>
                            <label class="pi-label">Company</label>
                            <input type="text" name="work_experience[{{ $i }}][company]"
                                   value="{{ $work['company'] ?? '' }}"
                                   placeholder="e.g. Glamour Beauty Salon" class="pi-input">
                        </div>
                        <div>
                            <label class="pi-label">Position</label>
                            <input type="text" name="work_experience[{{ $i }}][position]"
                                   value="{{ $work['position'] ?? '' }}"
                                   placeholder="e.g. Senior Cosmetologist" class="pi-input">
                        </div>
                        <div>
                            <label class="pi-label">Start Date</label>
                            <input type="text" name="work_experience[{{ $i }}][start_date]"
                                   value="{{ $work['start_date'] ?? '' }}"
                                   placeholder="Jan 2021" class="pi-input">
                        </div>
                        <div>
                            <label class="pi-label">End Date</label>
                            <input type="text" name="work_experience[{{ $i }}][end_date]"
                                   value="{{ $work['end_date'] ?? '' }}"
                                   placeholder="Present" class="pi-input">
                        </div>
                        <div class="pi-del-wrap">
                            <button type="button" class="pi-del-btn"
                                    onclick="removeRow(this,'work-list','.work-item','work_experience')"
                                    title="Remove">
                                <svg width="13" height="13" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="pi-label">Description <span style="font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span></label>
                        <textarea name="work_experience[{{ $i }}][description]"
                                  rows="2" placeholder="e.g. Provided bridal makeup, hair styling and skin care treatments..."
                                  class="pi-input" style="resize:vertical;">{{ $work['description'] ?? '' }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="pi-add-btn" onclick="addRow('work')">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Work Experience
            </button>
        </div>
    </div>

    {{-- ══ SECTION 4: EMERGENCY CONTACT ══ --}}
    <div class="pi-card">
        <div class="pi-card-head">
            <div style="width:26px;height:26px;background:#111;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="color:#fff;font-size:11px;font-weight:900;">4</span>
            </div>
            <h2 style="color:#111;font-size:12px;font-weight:800;letter-spacing:.09em;text-transform:uppercase;margin:0;">Emergency Contact</h2>
        </div>
        <div class="pi-card-body">
            <div id="emer-list">
                @foreach($emerData as $i => $emer)
                <div class="pi-row emer-item">
                    <div class="pi-emer-grid">
                        <div>
                            <label class="pi-label">Full Name</label>
                            <input type="text" name="emergency_contacts[{{ $i }}][name]"
                                   value="{{ $emer['name'] ?? '' }}"
                                   placeholder="e.g. Kamala Perera" class="pi-input">
                        </div>
                        <div>
                            <label class="pi-label">Phone Number</label>
                            <input type="text" name="emergency_contacts[{{ $i }}][phone]"
                                   value="{{ $emer['phone'] ?? '' }}"
                                   placeholder="e.g. 0771234567" class="pi-input">
                        </div>
                        <div>
                            <label class="pi-label">Relationship</label>
                            <input type="text" name="emergency_contacts[{{ $i }}][relationship]"
                                   value="{{ $emer['relationship'] ?? '' }}"
                                   placeholder="e.g. Mother" class="pi-input">
                        </div>
                        <div class="pi-del-wrap">
                            <button type="button" class="pi-del-btn"
                                    onclick="removeRow(this,'emer-list','.emer-item','emergency_contacts')"
                                    title="Remove">
                                <svg width="13" height="13" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="pi-add-btn" onclick="addRow('emer')">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Emergency Contact
            </button>
        </div>
    </div>

    {{-- ── SUBMIT ── --}}
    <div style="display:flex;justify-content:flex-end;padding-top:8px;">
        <button type="submit"
                style="display:inline-flex;align-items:center;gap:8px;padding:13px 32px;background:#111;color:#fff;font-size:14px;font-weight:700;border:none;border-radius:12px;cursor:pointer;letter-spacing:.02em;">
            <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            Save Personal Information
        </button>
    </div>

    </form>
</div>
</div>

<script>
/* ─────────────────────────────────────────
   Image preview
───────────────────────────────────────── */
document.getElementById('image-input').addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        var preview     = document.getElementById('img-preview');
        var placeholder = document.getElementById('img-placeholder');
        preview.src          = e.target.result;
        preview.style.display    = 'block';
        placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});

/* ─────────────────────────────────────────
   Remove row + re-index remaining names
───────────────────────────────────────── */
function removeRow(btn, listId, itemClass, prefix) {
    var list  = document.getElementById(listId);
    var items = list.querySelectorAll(itemClass);
    if (items.length <= 1) return;
    btn.closest(itemClass).remove();
    reIndex(listId, itemClass, prefix);
    syncDelBtns(listId, itemClass);
}

function syncDelBtns(listId, itemClass) {
    var list  = document.getElementById(listId);
    var count = list.querySelectorAll(itemClass).length;
    list.querySelectorAll('.pi-del-btn').forEach(function(b) {
        b.style.display = count <= 1 ? 'none' : 'flex';
    });
}

function reIndex(listId, itemClass, prefix) {
    var items = document.getElementById(listId).querySelectorAll(itemClass);
    items.forEach(function (item, idx) {
        item.querySelectorAll('input, textarea, select').forEach(function (el) {
            if (el.name) {
                el.name = el.name.replace(/\[\d+\]/, '[' + idx + ']');
            }
        });
    });
}

/* ─────────────────────────────────────────
   Build a new row element
───────────────────────────────────────── */
function makeDelBtn(listId, itemClass, prefix) {
    return '<div class="pi-del-wrap">' +
               '<button type="button" class="pi-del-btn" ' +
                   'onclick="removeRow(this,\'' + listId + '\',\'' + itemClass + '\',\'' + prefix + '\')" ' +
                   'title="Remove">' +
                   '<svg width="13" height="13" fill="none" stroke="#6b7280" viewBox="0 0 24 24">' +
                       '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>' +
                   '</svg>' +
               '</button>' +
           '</div>';
}

function addRow(type) {
    var cfg = {
        edu: {
            listId    : 'edu-list',
            itemClass : '.edu-item',
            prefix    : 'educational_qualifications',
            build     : function (idx) {
                var p = 'educational_qualifications[' + idx + ']';
                return '<div class="pi-row edu-item">' +
                           '<div class="pi-edu-grid">' +
                               field('Institution / University', 'text', p + '[institution]', 'e.g. IKICB, London School of Beauty') +
                               field('Qualification / Degree',   'text', p + '[qualification]', 'e.g. Diploma in Cosmetology') +
                               field('Year',                     'text', p + '[year]',           '2022') +
                               makeDelBtn('edu-list', '.edu-item', 'educational_qualifications') +
                           '</div>' +
                       '</div>';
            }
        },
        work: {
            listId    : 'work-list',
            itemClass : '.work-item',
            prefix    : 'work_experience',
            build     : function (idx) {
                var p = 'work_experience[' + idx + ']';
                return '<div class="pi-row work-item">' +
                           '<div class="pi-work-grid" style="margin-bottom:10px;">' +
                               field('Company',    'text', p + '[company]',    'e.g. Glamour Beauty Salon') +
                               field('Position',   'text', p + '[position]',   'e.g. Senior Cosmetologist') +
                               field('Start Date', 'text', p + '[start_date]', 'Jan 2021') +
                               field('End Date',   'text', p + '[end_date]',   'Present') +
                               makeDelBtn('work-list', '.work-item', 'work_experience') +
                           '</div>' +
                           '<div>' +
                               '<label class="pi-label">Description ' +
                                   '<span style="font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span>' +
                               '</label>' +
                               '<textarea name="' + p + '[description]" rows="2" ' +
                                   'placeholder="e.g. Provided bridal makeup, hair styling and skin care treatments..." ' +
                                   'class="pi-input" style="resize:vertical;"></textarea>' +
                           '</div>' +
                       '</div>';
            }
        },
        emer: {
            listId    : 'emer-list',
            itemClass : '.emer-item',
            prefix    : 'emergency_contacts',
            build     : function (idx) {
                var p = 'emergency_contacts[' + idx + ']';
                return '<div class="pi-row emer-item">' +
                           '<div class="pi-emer-grid">' +
                               field('Full Name',     'text', p + '[name]',         'e.g. Kamala Perera') +
                               field('Phone Number',  'text', p + '[phone]',        'e.g. 0771234567') +
                               field('Relationship',  'text', p + '[relationship]', 'e.g. Mother') +
                               makeDelBtn('emer-list', '.emer-item', 'emergency_contacts') +
                           '</div>' +
                       '</div>';
            }
        }
    };

    var c    = cfg[type];
    var list = document.getElementById(c.listId);
    var idx  = list.querySelectorAll(c.itemClass).length;
    var tmp  = document.createElement('div');
    tmp.innerHTML = c.build(idx);
    list.appendChild(tmp.firstElementChild);
    syncDelBtns(c.listId, c.itemClass);
}

/* initialise delete-button visibility on page load */
[['edu-list','.edu-item'],['work-list','.work-item'],['emer-list','.emer-item']].forEach(function(p){
    syncDelBtns(p[0], p[1]);
});

/* helper: labelled input cell */
function field(labelText, inputType, name, placeholder) {
    return '<div>' +
               '<label class="pi-label">' + labelText + '</label>' +
               '<input type="' + inputType + '" name="' + name + '" ' +
                   'placeholder="' + placeholder + '" class="pi-input">' +
           '</div>';
}
</script>

@endsection