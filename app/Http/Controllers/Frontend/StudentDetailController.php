<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentDetailController extends Controller
{
    public function show()
    {
        $user   = auth()->user();
        $detail = $user->studentDetail;

        return view('frontend.dashboard.personal-info', compact('detail'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_with_initials' => 'required|string|max:255',
            'full_name'          => 'required|string|max:255',
            'date_of_birth'      => 'required|date|before:today',
            'gender'             => 'required|in:male,female,other',
            'id_number'          => 'required|string|max:50',
            'past_school'        => 'nullable|string|max:255',
            'phone'              => 'required|string|max:20',
            'permanent_address'  => 'nullable|string|max:1000',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'educational_qualifications'                 => 'nullable|array',
            'educational_qualifications.*.institution'  => 'nullable|string|max:255',
            'educational_qualifications.*.qualification' => 'nullable|string|max:255',
            'educational_qualifications.*.year'         => 'nullable|string|max:10',

            'work_experience'               => 'nullable|array',
            'work_experience.*.company'     => 'nullable|string|max:255',
            'work_experience.*.position'    => 'nullable|string|max:255',
            'work_experience.*.start_date'  => 'nullable|string|max:20',
            'work_experience.*.end_date'    => 'nullable|string|max:20',
            'work_experience.*.description' => 'nullable|string|max:500',

            'emergency_contacts'                => 'nullable|array',
            'emergency_contacts.*.name'         => 'nullable|string|max:255',
            'emergency_contacts.*.phone'        => 'nullable|string|max:20',
            'emergency_contacts.*.relationship' => 'nullable|string|max:100',
        ]);

        $user      = auth()->user();
        $existing  = $user->studentDetail;

        if ($request->hasFile('image')) {
            if ($existing && $existing->image) {
                Storage::disk('public')->delete($existing->image);
            }
            $validated['image'] = $request->file('image')->store('student-images', 'public');
        } elseif ($existing) {
            unset($validated['image']);
        }

        // Filter empty rows from JSON arrays
        $validated['educational_qualifications'] = $this->filterEmpty(
            $validated['educational_qualifications'] ?? [],
            ['institution', 'qualification']
        );
        $validated['work_experience'] = $this->filterEmpty(
            $validated['work_experience'] ?? [],
            ['company', 'position']
        );
        $validated['emergency_contacts'] = $this->filterEmpty(
            $validated['emergency_contacts'] ?? [],
            ['name', 'phone']
        );

        $user->studentDetail()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('dashboard.personal-info')
            ->with('success', 'Personal information saved successfully!');
    }

    private function filterEmpty(array $items, array $requiredKeys): array
    {
        return array_values(array_filter($items, function ($item) use ($requiredKeys) {
            foreach ($requiredKeys as $key) {
                if (empty($item[$key])) return false;
            }
            return true;
        }));
    }
}
