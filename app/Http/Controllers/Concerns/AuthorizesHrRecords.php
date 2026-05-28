<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait AuthorizesHrRecords
{
    protected function hrDepartmentName(User $user): ?string
    {
        return $user->department?->name;
    }

    protected function scopeHrRecordsForUser(Builder $query, string $departmentColumn = 'department'): Builder
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isManager() || $user->isDceo()) {
            $model = $query->getModel();
            $foreignKey = in_array('user_id', $model->getFillable()) ? 'user_id' : 'created_by';

            return $query->where($foreignKey, $user->id);
        }

        $departmentName = $this->hrDepartmentName($user);

        if ($departmentName) {
            return $query->where($departmentColumn, $departmentName);
        }

        return $query->whereRaw('1 = 0');
    }

    protected function canViewHrRecord(Model $record, string $departmentColumn = 'department'): bool
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isManager() || $user->isDceo()) {
            $foreignKey = in_array('user_id', $record->getFillable()) ? 'user_id' : 'created_by';

            return (int) ($record->{$foreignKey} ?? 0) === (int) $user->id;
        }

        $departmentName = $this->hrDepartmentName($user);

        if (! $departmentName) {
            return false;
        }

        return ($record->{$departmentColumn} ?? null) === $departmentName;
    }

    protected function canEditHrRecord(Model $record): bool
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isManager() || $user->isDceo()) {
            $ownerId = $record->created_by ?? $record->user_id ?? 0;
            if ((int) $ownerId !== (int) $user->id) {
                return false;
            }
            $status = $record->approval_status ?? null;

            return ! $status || $status === 'Pending';
        }

        return false;
    }

    protected function canDeleteHrRecord(Model $record): bool
    {
        return auth()->user()->isAdmin();
    }

    protected function authorizeViewHrRecord(Model $record, string $departmentColumn = 'department'): void
    {
        if (! $this->canViewHrRecord($record, $departmentColumn)) {
            abort(403, 'You are not authorized to view this record.');
        }
    }

    protected function authorizeEditHrRecord(Model $record): void
    {
        if (! $this->canEditHrRecord($record)) {
            abort(403, 'You are not authorized to edit this record.');
        }
    }

    protected function authorizeDeleteHrRecord(Model $record): void
    {
        if (! $this->canDeleteHrRecord($record)) {
            abort(403, 'You are not authorized to delete this record.');
        }
    }

    protected function authorizeCreateHrRecord(): void
    {
        $user = auth()->user();

        if ($user->isAdmin() || $user->isManager() || $user->isDceo()) {
            return;
        }

        abort(403, 'You are not authorized to create records.');
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @param  array<string, mixed>  $attributes
     */
    protected function assertNoDuplicateHrSubmission(string $modelClass, array $attributes): void
    {
        $query = $modelClass::query()->where('created_by', auth()->id());

        foreach ($attributes as $column => $value) {
            $query->where($column, $value);
        }

        if ($query->where('created_at', '>=', now()->subMinutes(2))->exists()) {
            abort(422, 'A similar record was just submitted. Please wait before submitting again.');
        }
    }
}
