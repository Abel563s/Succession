<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class TransitionController extends AdminHrModuleController
{
    public function index(Request $request)
    {
        $query = \App\Models\Transition::with(['items', 'creator']);

        $this->scopeHrRecordsForUser($query);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('department', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('items', function ($iq) use ($search) {
                        $iq->where('critical_role', 'like', "%{$search}%")
                            ->orWhere('current_holder', 'like', "%{$search}%")
                            ->orWhere('successor', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('critical_role')) {
            $query->whereHas('items', function ($iq) {
                $iq->where('critical_role', 'like', '%'.request('critical_role').'%');
            });
        }

        if ($request->filled('current_holder')) {
            $query->whereHas('items', function ($iq) {
                $iq->where('current_holder', 'like', '%'.request('current_holder').'%');
            });
        }

        if ($request->filled('successor')) {
            $query->whereHas('items', function ($iq) {
                $iq->where('successor', 'like', '%'.request('successor').'%');
            });
        }

        if ($request->filled('transition_date')) {
            $query->whereHas('items', function ($iq) {
                $iq->whereDate('transition_date', request('transition_date'));
            });
        }

        $records = $query->latest()->paginate(10)->withQueryString();

        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = \App\Models\Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = \App\Models\Department::orderBy('name')->get();
        }

        return view('admin.transition.index', compact('records', 'departments'));
    }

    public function create()
    {
        $this->authorizeCreateHrRecord();

        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = \App\Models\Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = \App\Models\Department::orderBy('name')->get();
        }

        return view('admin.transition.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->authorizeCreateHrRecord();

        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'status' => 'required|string|in:Planned,In Progress,Completed,Delayed',
            'signature' => auth()->user()->signature_path ? 'nullable|image|max:500' : 'required|image|max:500',
            'items' => 'required|array|min:1',
            'items.*.critical_role' => 'required|string|max:255',
            'items.*.current_holder' => 'required|string|max:255',
            'items.*.successor' => 'required|string|max:255',
            'items.*.transition_date' => 'required|date',
            'dceo_signature' => 'nullable|image|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $path = $request->hasFile('signature')
                ? $request->file('signature')->store('signatures/transitions', 'public')
                : auth()->user()->signature_path;

            $data = [
                'department' => $validated['department'],
                'status' => $validated['status'],
                'signature_path' => $path,
            ];

            if ($request->hasFile('dceo_signature')) {
                $data['dceo_signature_path'] = $request->file('dceo_signature')->store('signatures/transitions', 'public');
            } elseif (auth()->user()->isDceo() && auth()->user()->signature_path) {
                $data['dceo_signature_path'] = auth()->user()->signature_path;
            }

            $data['user_id'] = auth()->id();
            $transition = \App\Models\Transition::create($data);

            foreach ($validated['items'] as $index => $itemData) {
                $transition->items()->create([
                    'row_number' => $index + 1,
                    'critical_role' => $itemData['critical_role'],
                    'current_holder' => $itemData['current_holder'],
                    'successor' => $itemData['successor'],
                    'transition_date' => $itemData['transition_date'],
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.transition.show', $transition)->with('success', 'Transition plan created successfully. Pending approval.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            return back()->withInput()->with('error', 'An error occurred: '.$e->getMessage());
        }
    }

    public function show(\App\Models\Transition $transition)
    {
        $transition->load(['items', 'creator']);

        return view('admin.transition.show', compact('transition'));
    }

    public function edit(\App\Models\Transition $transition)
    {
        $transition->load('items');
        if (! auth()->user()->isAdmin() && ! auth()->user()->isDceo()) {
            $departments = \App\Models\Department::where('id', auth()->user()->department_id)->get();
        } else {
            $departments = \App\Models\Department::orderBy('name')->get();
        }

        return view('admin.transition.edit', compact('transition', 'departments'));
    }

    public function update(Request $request, \App\Models\Transition $transition)
    {
        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'status' => 'required|string|in:Planned,In Progress,Completed,Delayed',
            'signature' => 'nullable|image|max:500',
            'items' => 'required|array|min:1',
            'items.*.critical_role' => 'required|string|max:255',
            'items.*.current_holder' => 'required|string|max:255',
            'items.*.successor' => 'required|string|max:255',
            'items.*.transition_date' => 'required|date',
            'dceo_signature' => 'nullable|image|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $updateData = [
                'department' => $validated['department'],
                'status' => $validated['status'],
            ];

            if ($request->hasFile('signature')) {
                if ($transition->signature_path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($transition->signature_path);
                }
                $updateData['signature_path'] = $request->file('signature')->store('signatures/transitions', 'public');
            }

            if ($request->hasFile('dceo_signature')) {
                if ($transition->dceo_signature_path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($transition->dceo_signature_path);
                }
                $updateData['dceo_signature_path'] = $request->file('dceo_signature')->store('signatures/transitions', 'public');
            } elseif (auth()->user()->isDceo() && auth()->user()->signature_path) {
                $updateData['dceo_signature_path'] = auth()->user()->signature_path;
            }

            $transition->update($updateData);

            $transition->items()->delete();

            foreach ($validated['items'] as $index => $itemData) {
                $transition->items()->create([
                    'row_number' => $index + 1,
                    'critical_role' => $itemData['critical_role'],
                    'current_holder' => $itemData['current_holder'],
                    'successor' => $itemData['successor'],
                    'transition_date' => $itemData['transition_date'],
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.transition.index')->with('success', 'Transition plan updated successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            return back()->withInput()->with('error', 'An error occurred: '.$e->getMessage());
        }
    }

    public function destroy(\App\Models\Transition $transition)
    {
        if ($transition->signature_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($transition->signature_path);
        }
        if ($transition->dceo_signature_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($transition->dceo_signature_path);
        }
        $transition->delete();

        return redirect()->route('admin.transition.index')->with('success', 'Transition plan deleted successfully.');
    }
}
