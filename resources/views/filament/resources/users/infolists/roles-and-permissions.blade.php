@php
    use Illuminate\Support\Str;
    use Spatie\Permission\Models\Permission;

    $roles = $user->roles;
    $groupedPermissions = $user->getAllPermissions()
        ->groupBy(fn (Permission $permission): string => $permission->type ?: Str::after($permission->name, ' '))
        ->sortKeys();
@endphp

<div class="space-y-6">
    <div>
        <h3 class="text-lg font-semibold">Roles</h3>

        <div
            class="fi-fo-checkbox-list-options mt-3"
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(12rem, 1fr)); gap: 1rem;"
        >
            @forelse ($roles as $role)
                <label class="fi-fo-checkbox-list-option cursor-default">
                    <input
                        aria-readonly="true"
                        checked
                        tabindex="-1"
                        type="checkbox"
                        class="fi-checkbox-input pointer-events-none"
                    />

                    <div class="fi-fo-checkbox-list-option-text">
                        <span class="fi-fo-checkbox-list-option-label">{{ $role->name }}</span>
                    </div>
                </label>
            @empty
                <span class="text-sm text-gray-500 dark:text-gray-400">No roles assigned.</span>
            @endforelse
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold">Permissions</h3>

        <div class="mt-4 space-y-6">
            @forelse ($groupedPermissions as $group => $permissions)
                <div>
                    <h4 style="font-size: 1.5rem; font-weight: 700;">{{ Str::headline($group) }}</h4>

                    <div
                        class="fi-fo-checkbox-list-options mt-3"
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(12rem, 1fr)); gap: 1rem;"
                    >
                        @foreach ($permissions as $permission)
                            <label class="fi-fo-checkbox-list-option cursor-default">
                                <input
                                    aria-readonly="true"
                                    checked
                                    tabindex="-1"
                                    type="checkbox"
                                    class="fi-checkbox-input pointer-events-none"
                                />

                                <div class="fi-fo-checkbox-list-option-text">
                                    <span class="fi-fo-checkbox-list-option-label">
                                        {{ Str::headline(Str::before($permission->name, ' ').' '.Str::singular($group)) }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @empty
                <span class="text-sm text-gray-500 dark:text-gray-400">No permissions assigned.</span>
            @endforelse
        </div>
    </div>
</div>
