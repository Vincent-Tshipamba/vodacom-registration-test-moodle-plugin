<div id="loadingPlaceholders" class="hidden grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mt-5">

    <?php for ($i = 0; $i < 4; $i++): ?>
        <div class="card animate-pulse shadow-lg">
            <div class="card-body">

                <!-- Photo -->
                <div
                    class="relative flex justify-center items-center bg-slate-100 dark:bg-zink-600 mx-auto rounded-full size-16 text-lg">
                    <div
                        class="border border-gray-300 dark:border-gray-600 rounded-full size-16 bg-gray-200 dark:bg-gray-600">
                    </div>
                </div>

                <!-- Infos candidat -->
                <div class="mt-2 text-center">

                    <!-- Nom -->
                    <div class="mx-auto mb-2 h-5 bg-gray-200 dark:bg-gray-600 rounded w-3/4"></div>

                    <!-- Ville diplôme -->
                    <div class="mx-auto mb-3 h-4 bg-gray-200 dark:bg-gray-600 rounded w-1/2"></div>

                    <!-- Badge statut -->
                    <div
                        class="mx-auto flex items-center justify-center gap-1 px-2.5 py-0.5 rounded w-fit bg-gray-100 dark:bg-gray-700">
                        <div class="h-4 w-4 bg-gray-200 dark:bg-gray-600 rounded-full"></div>
                        <div class="h-3 bg-gray-200 dark:bg-gray-600 rounded w-24"></div>
                    </div>

                    <!-- Code inscription -->
                    <div class="mx-auto mt-3 h-4 bg-gray-200 dark:bg-gray-600 rounded w-20"></div>
                </div>

                <!-- Boutons -->
                <div class="flex gap-2 mt-5">

                    <!-- Bouton téléphone -->
                    <div class="grow h-[37.5px] bg-gray-200 dark:bg-gray-600 rounded-lg"></div>

                    <!-- Bouton menu -->
                    <div class="h-[37.5px] w-[37.5px] bg-gray-200 dark:bg-gray-600 rounded-lg"></div>

                </div>
            </div>
        </div>
    <?php endfor; ?>

</div>