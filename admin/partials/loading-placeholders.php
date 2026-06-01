<?php for ($i = 0; $i < 4; $i++): ?>
    <div class="card animate-pulse">
        <div class="card-body">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0">
                    <div class="h-14 w-14 rounded-full bg-gray-200 dark:bg-gray-600"></div>
                </div>
                <div class="flex-1 space-y-2">
                    <div class="h-4 bg-gray-200 dark:bg-gray-600 rounded w-3/4"></div>
                    <div class="h-3 bg-gray-200 dark:bg-gray-600 rounded w-1/2"></div>
                    <div class="h-3 bg-gray-200 dark:bg-gray-600 rounded w-1/3"></div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-gray-50 dark:bg-gray-700/50 p-3 flex justify-end gap-2">
            <div class="h-8 bg-gray-200 dark:bg-gray-600 rounded w-16"></div>
        </div>
    </div>
<?php endfor; ?>