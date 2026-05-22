<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\HrSignatureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(
        protected HrSignatureService $signatures,
    ) {}

    public function index(Request $request)
    {
        $query = User::with('department');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->has('status') && $request->status !== null && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $departments = \App\Models\Department::orderBy('name')->get();

        // Stats Counter
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $adminUsers = User::where('role', 'admin')->count();
        $deptUsers = User::where('role', '!=', 'admin')->count();
        $disabledUsers = User::where('is_active', false)->count();

        return view('admin.users.index', compact(
            'users', 'departments', 'totalUsers', 'activeUsers', 'adminUsers', 'deptUsers', 'disabledUsers'
        ));
    }

    public function edit(User $user)
    {
        $departments = \App\Models\Department::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'role' => ['required', Rule::in(['admin', 'manager', 'user'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'signature' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($validated['role'] === 'manager' && ! $request->hasFile('signature')) {
            return back()
                ->withErrors(['signature' => 'Please upload the manager signature image.'])
                ->withInput();
        }

        $prefix = \App\Models\SystemSetting::where('key', 'employee_id_prefix')->first()?->value ?? 'EMP';
        $nextId = User::count() + 1;
        $employeeId = $prefix.'-'.str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'is_active' => $validated['is_active'] ?? true,
            'employee_id' => $employeeId,
            'department_id' => $validated['department_id'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        if ($validated['role'] === 'manager' && $request->hasFile('signature')) {
            $this->signatures->storeUserSignature($user, $request->file('signature'));
        }

        return redirect()->route('admin.users.index')->with('success', 'User node initialized successfully.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'manager', 'user'])],
            'is_active' => ['required', 'boolean'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'signature' => ['nullable', 'image', 'max:2048'],
            'remove_signature' => ['nullable', 'boolean'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'is_active' => $validated['is_active'],
            'department_id' => $validated['department_id'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->boolean('remove_signature')) {
            $this->signatures->deletePublicFile($user->signature_path);
            $user->signature_path = null;
        } elseif ($request->hasFile('signature') && $validated['role'] === 'manager') {
            $this->signatures->storeUserSignature($user, $request->file('signature'));
        } elseif ($validated['role'] !== 'manager' && $user->signature_path) {
            $this->signatures->deletePublicFile($user->signature_path);
            $user->signature_path = null;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User profile updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
