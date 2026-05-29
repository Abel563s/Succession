@props([
    'record',
    'module',
])

@php
    $status = $record->approval_status ?? 'Pending';
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 flex flex-col md:flex-row items-center justify-between gap-4']) }}>
    <div class="flex items-center gap-4">
        @if($status === 'Approved')
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-slate-900">Record Approved</h3>
                <p class="text-xs text-slate-500 font-medium">This record has been officially approved and activated.</p>
            </div>
        @elseif($status === 'Rejected')
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                <i data-lucide="x-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-slate-900">Record Rejected</h3>
                <p class="text-xs text-slate-500 font-medium">This record has been rejected by the administrator.</p>
            </div>
        @else
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0 animate-pulse">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-slate-900">Pending Approval</h3>
                <p class="text-xs text-slate-500 font-medium">This record is currently waiting for administrator review.</p>
            </div>
        @endif
    </div>

    <div class="flex items-center gap-3">
        @if($status === 'Pending' && auth()->user()->isAdmin())
            <form action="{{ route('admin.approval.approve', ['module' => $module, 'id' => $record->id]) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hr-approval-btn-approve hover:scale-[1.02] active:scale-95 duration-200">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    Approve
                </button>
            </form>
            <form action="{{ route('admin.approval.reject', ['module' => $module, 'id' => $record->id]) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hr-approval-btn-reject hover:scale-[1.02] active:scale-95 duration-200">
                    <i data-lucide="x" class="w-4 h-4"></i>
                    Reject
                </button>
            </form>
        @else
            <x-hr-approval-badge :status="$status" class="px-4 py-2 text-xs tracking-widest" />
        @endif
    </div>
</div>
