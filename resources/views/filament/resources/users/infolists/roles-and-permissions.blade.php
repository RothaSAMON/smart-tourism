<div style="display: grid; gap: 2rem;">
    <section>
        <div style="display: flex; align-items: baseline; justify-content: space-between; gap: 1rem;">
            <h3 style="font-size: 1.25rem; font-weight: 700;">Roles</h3>
            <span style="font-size: 0.875rem; opacity: 0.7;">{{ $roles->count() }} assigned</span>
        </div>

        <div
            class="fi-fo-checkbox-list-options"
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(10rem, 1fr)); gap: 0.5rem; margin-top: 0.75rem;"
        >
            @forelse ($roles as $role)
                <label
                    class="fi-fo-checkbox-list-option cursor-default"
                    style="align-items: center; background: color-mix(in srgb, currentColor 5%, transparent); border-radius: 0.5rem; display: flex; gap: 0.625rem; min-width: 0; padding: 0.625rem 0.75rem;"
                >
                    <input
                        aria-readonly="true"
                        checked
                        tabindex="-1"
                        type="checkbox"
                        class="fi-checkbox-input pointer-events-none"
                        style="flex: 0 0 auto;"
                    />

                    <div class="fi-fo-checkbox-list-option-text">
                        <span class="fi-fo-checkbox-list-option-label">{{ $role->name }}</span>
                    </div>
                </label>
            @empty
                <span class="text-sm text-gray-500 dark:text-gray-400">No roles assigned.</span>
            @endforelse
        </div>
    </section>

    <section>
        <div style="display: flex; align-items: baseline; justify-content: space-between; gap: 1rem;">
            <h3 style="font-size: 1.25rem; font-weight: 700;">Permissions</h3>
            <span style="font-size: 0.875rem; opacity: 0.7;">{{ $groupedPermissions->count() }} modules</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 22rem), 1fr)); gap: 1rem; margin-top: 0.75rem;">
            @forelse ($groupedPermissions as $group => $permissions)
                <article
                    style="background: color-mix(in srgb, currentColor 4%, transparent); border: 1px solid color-mix(in srgb, currentColor 12%, transparent); border-radius: 0.75rem; padding: 1rem;"
                >
                    <div style="display: flex; align-items: baseline; justify-content: space-between; gap: 1rem;">
                        <h4 style="font-size: 1.125rem; font-weight: 700;">{{ \Illuminate\Support\Str::headline($group) }}</h4>
                        <span style="font-size: 0.75rem; opacity: 0.7;">{{ $permissions->count() }}</span>
                    </div>

                    <div
                        class="fi-fo-checkbox-list-options"
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(10rem, 1fr)); gap: 0.5rem; margin-top: 0.75rem;"
                    >
                        @foreach ($permissions as $permission)
                            <label
                                class="fi-fo-checkbox-list-option cursor-default"
                                style="align-items: center; background: color-mix(in srgb, currentColor 5%, transparent); border-radius: 0.5rem; display: flex; gap: 0.625rem; min-width: 0; padding: 0.625rem 0.75rem;"
                            >
                                <input
                                    aria-readonly="true"
                                    checked
                                    tabindex="-1"
                                    type="checkbox"
                                    class="fi-checkbox-input pointer-events-none"
                                    style="flex: 0 0 auto;"
                                />

                                <div class="fi-fo-checkbox-list-option-text">
                                    <span class="fi-fo-checkbox-list-option-label">
                                        {{ \Illuminate\Support\Str::headline(\Illuminate\Support\Str::before($permission->name, ' ').' '.\Illuminate\Support\Str::singular($group)) }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </article>
            @empty
                <span class="text-sm text-gray-500 dark:text-gray-400">No permissions assigned.</span>
            @endforelse
        </div>
    </section>
</div>
