<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HrSignatureService
{
    public function resolveManagerSignature(Request $request, string $uploadField = 'signature', string $storageDirectory = 'signatures'): ?string
    {
        if ($request->boolean('use_saved_signature') && auth()->user()?->signature_path) {
            return auth()->user()->signature_path;
        }

        if ($request->hasFile($uploadField)) {
            return $request->file($uploadField)->store($storageDirectory, 'public');
        }

        return null;
    }

    public function resolveDualSignature(
        Request $request,
        string $managerField = 'manager_sig',
        string $candidateField = 'candidate_sig',
        string $managerDirectory = 'signatures/manager',
        string $candidateDirectory = 'signatures/candidate',
    ): array {
        $managerPath = null;
        $candidatePath = null;

        if ($request->boolean('use_saved_manager_signature') && auth()->user()?->signature_path) {
            $managerPath = auth()->user()->signature_path;
        } elseif ($request->hasFile($managerField)) {
            $managerPath = $request->file($managerField)->store($managerDirectory, 'public');
        }

        if ($request->hasFile($candidateField)) {
            $candidatePath = $request->file($candidateField)->store($candidateDirectory, 'public');
        }

        return [
            'manager' => $managerPath,
            'candidate' => $candidatePath,
        ];
    }

    public function storeUserSignature(User $user, UploadedFile $file): string
    {
        if ($user->signature_path) {
            Storage::disk('public')->delete($user->signature_path);
        }

        $path = $file->store('signatures/users', 'public');
        $user->update(['signature_path' => $path]);

        return $path;
    }

    public function deletePublicFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
