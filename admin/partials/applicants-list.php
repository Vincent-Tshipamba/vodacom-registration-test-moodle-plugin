<div class="p-4 overflow-x-auto">
    <table id="applicants-table" class="w-full whitespace-nowrap display" width="100%">
        <!-- Table header -->
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-left uppercase tracking-wider">
                    Nom complet
                </th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-left uppercase tracking-wider">
                    Téléphone
                </th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-left uppercase tracking-wider">
                    Ville
                </th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-left uppercase tracking-wider">
                    Pourcentage
                </th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-left uppercase tracking-wider">
                    Statut
                </th>
                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-left uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <!-- Table body will be loaded via AJAX -->
        <tbody id="applicantsTableBody" class="divide-y divide-gray-200">
            <?php foreach ($applicants as $applicant): ?>
                <tr>
                    <td class="px-6 py-4 text-gray-900 text-sm whitespace-nowrap">
                        <?= $applicant->fullname ?>
                    </td>
                    <td class="px-6 py-4 text-gray-900 text-sm whitespace-nowrap">
                        <?= $applicant->phone ?>
                    </td>
                    <td class="px-6 py-4 text-gray-900 text-sm whitespace-nowrap">
                        <?= $applicant->diplomacityname ?>
                    </td>
                    <td class="px-6 py-4 text-gray-900 text-sm whitespace-nowrap">
                        <?= floatval($applicant->percentage) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                <?= $statusClasses[$applicant->statusname]['classes'] ?>">
                            <?= get_string($applicant->statusname, 'local_scholarship'); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-sm whitespace-nowrap">
                        <a href="" class="mr-3 text-blue-600 hover:text-blue-900">Voir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>