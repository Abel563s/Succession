<x-app-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
            <div class="flex flex-col">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Critical Role Management</h1>
                <p class="text-xs text-slate-400 font-medium italic">Evaluating and tracking essential positions and succession planning.</p>
            </div>

            <!-- Perfectly Centered Badge -->
            <div class="hidden lg:flex items-center justify-center">
                <div class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl hover:border-[#111111]/20 transition-all duration-500 group/badge">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#111111] transition-colors group-hover/badge:bg-[#111111] group-hover/badge:text-white shadow-inner">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 transition-transform group-hover/badge:scale-110"></i>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <span class="text-2xl font-black text-slate-900 tracking-tighter leading-none">{{ $records->total() }}</span>
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></div>
                        </div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover/badge:text-slate-600 transition-colors">Critical Roles</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3">
                <x-admin-module-help
                    name="help-critical-roles"
                    title="Critical Role Guide"
                    description="Identify and document essential roles that are critical to business continuity, and ensure each nominee is prepared for future succession."
                    :sections="[
                        ['icon' => 'shield-check', 'title' => 'Purpose', 'content' => 'Identify positions that are essential to business continuity and organizational success.'],
                        ['icon' => 'list', 'title' => 'Instructions', 'content' => [
                            'Enter the details of the current critical role.',
                            'Provide the name of the nominated successor(s) for the role.',
                            'Ensure the nominee has the potential and capability to assume the role in the future.',
                        ]],
                    ]"
                />

                <a href="{{ route('admin.critical-roles.create') }}"
                    class="bg-gradient-to-r from-[#111111] to-[#00333B] hover:to-[#111111] text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 transition-all duration-300 shadow-lg shadow-[#111111]/20 hover:shadow-[#111111]/30 hover:scale-[1.02] active:scale-95 group/btn relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-white/10 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300">
                    </div>
                    <i data-lucide="plus" class="w-4 h-4 relative z-10 transition-transform group-hover/btn:rotate-90"></i>
                    <span class="relative z-10">Add Critical Role</span>
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="flex justify-center">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm inline-block">
                <form action="{{ route('admin.critical-roles.index') }}" method="GET"
                    class="flex flex-wrap items-end justify-center gap-4">
                    <div class="w-64 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Search</label>
                        <div class="relative">
                            <i data-lucide="search"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Name, Role, Dept..."
                                class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none transition-all text-xs font-bold text-slate-700">
                        </div>
                    </div>

                    <div class="w-48 text-left">
                        <label
                            class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Department</label>
                        <select name="department"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none transition-all text-xs font-bold text-slate-700 appearance-none">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}" {{ request('department') == $dept->name ? 'selected' : '' }}>
                                    {{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-40 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Vacancy
                            Risk</label>
                        <select name="vacancy_risk"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-[#111111] outline-none transition-all text-xs font-bold text-slate-700 appearance-none">
                            <option value="">All Risks</option>
                            <option value="High" {{ request('vacancy_risk') == 'High' ? 'selected' : '' }}>High</option>
                            <option value="Moderate" {{ request('vacancy_risk') == 'Moderate' ? 'selected' : '' }}>Moderate
                            </option>
                            <option value="Low" {{ request('vacancy_risk') == 'Low' ? 'selected' : '' }}>Low</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="w-10 h-10 filter-toolbar-btn rounded-xl group/filter"
                            title="Apply Filters">
                            <i data-lucide="filter" class="w-4 h-4 transition-transform group-hover/filter:scale-110"></i>
                        </button>
                        <a href="{{ route('admin.critical-roles.index') }}"
                            class="w-10 h-10 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-all group/reset"
                            title="Reset Filters">
                            <i data-lucide="refresh-ccw"
                                class="w-4 h-4 transition-transform group-hover/reset:rotate-180 duration-500"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#111111] to-[#00333B] text-white text-[10px] font-black uppercase tracking-widest">
                            <th class="px-4 py-4 border-b border-white/5 text-center">#</th>
                            <th class="px-6 py-4 border-b border-white/5">Employee & Role</th>
                            <th class="px-6 py-4 border-b border-white/5">Department</th>
                            <th class="px-6 py-4 border-b border-white/5">Status & Risks</th>
                            <th class="px-6 py-4 border-b border-white/5">Successors</th>
                            <th class="px-6 py-4 border-b border-white/5">Mitigation Plan</th>
                            <th class="px-6 py-4 border-b border-white/5">Signature</th>
                            <th class="px-6 py-4 border-b border-white/5">Approval</th>
                            <th class="px-6 py-4 border-b border-white/5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($records as $record)
                            <tr class="hover:bg-slate-50/50 transition-colors group text-sm">
                                <td class="px-4 py-5 text-center font-bold text-slate-400 text-xs">
                                    {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-black text-[#00515f]">
                                            {{ substr($record->employee_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-tight">{{ $record->employee_name }}
                                            </p>
                                            <p class="text-xs text-slate-500 font-medium mt-0.5">
                                                {{ $record->critical_role }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-tight">
                                        {{ $record->department }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] text-slate-400 font-bold uppercase w-12">Risk:</span>
                                            @php
                                                $riskColor = match ($record->vacancy_risk) {
                                                    'High' => 'bg-rose-500',
                                                    'Moderate' => 'bg-amber-500',
                                                    'Low' => 'bg-emerald-500',
                                                    default => 'bg-slate-400'
                                                };
                                            @endphp
                                            <span class="flex items-center gap-1.5">
                                                <div class="w-2 h-2 rounded-full {{ $riskColor }}"></div>
                                                <span
                                                    class="text-xs font-bold text-slate-700">{{ $record->vacancy_risk }}</span>
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] text-slate-400 font-bold uppercase w-12">Impact:</span>
                                            <span
                                                class="text-xs font-bold text-slate-700">{{ $record->position_impact }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] text-slate-400 font-bold uppercase w-12">Status:</span>
                                            <span
                                                class="text-xs font-bold text-slate-700">{{ $record->position_status }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="space-y-2">
                                        @if($record->successor_1_name)
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500">
                                                    1</div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-700 leading-none">
                                                        {{ $record->successor_1_name }}</p>
                                                    <p class="text-[9px] text-slate-400 font-medium mt-0.5">
                                                        {{ $record->successor_1_readiness }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        @if($record->successor_2_name)
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500">
                                                    2</div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-700 leading-none">
                                                        {{ $record->successor_2_name }}</p>
                                                    <p class="text-[9px] text-slate-400 font-medium mt-0.5">
                                                        {{ $record->successor_2_readiness }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-xs text-slate-500 line-clamp-2 max-w-[200px]"
                                        title="{{ $record->mitigation_plan }}">
                                        {{ $record->mitigation_plan }}
                                    </p>
                                </td>
                                <td class="px-6 py-5">
                                    @if($record->signature_path)
                                        <div x-data="{ open: false }">
                                            <img src="{{ \App\Support\StorageUrl::public($record->signature_path) }}" @click="open = true"
                                                class="w-12 h-12 object-cover rounded-lg border border-slate-200 cursor-pointer hover:border-[#D4AF37] transition-all"
                                                alt="Signature">
 
                                            <!-- Simple Modal for Image Preview -->
                                            <div x-show="open" @click="open = false" x-cloak
                                                class="fixed inset-0 z-50 flex items-center justify-center modal-overlay p-4">
                                                <div class="bg-white p-2 rounded-2xl max-w-2xl">
                                                    <img src="{{ \App\Support\StorageUrl::public($record->signature_path) }}"
                                                        class="max-w-full rounded-xl" alt="Signature Preview">
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-black uppercase text-slate-400">No Signature</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <x-hr-approval-badge :status="$record->approval_status" />
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.critical-roles.show', $record) }}"
                                            class="table-action-btn"
                                            title="View Details">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
 
                                        @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && ($record->approval_status === 'Pending' || (($record->created_by ?? $record->user_id) == auth()->id() && (!$record->approval_status || $record->approval_status === 'Pending')))))
                                            <a href="{{ route('admin.critical-roles.edit', $record) }}"
                                                class="table-action-btn"
                                                title="Edit Evaluation">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>
                                        @endif

                                        @if(auth()->user()->isAdmin())
                                            <form action="{{ route('admin.critical-roles.destroy', $record) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this record?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="table-action-btn table-action-btn--delete"
                                                    title="Delete Record">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="file-warning" class="w-8 h-8 text-slate-300"></i>
                                        </div>
                                        <p class="text-slate-500 font-medium">No evaluation records found matching your
                                            criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($records->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>