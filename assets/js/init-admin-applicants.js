document.addEventListener('DOMContentLoaded', () => {
    // Initialiser DataTable avec les options de pagination
    const dataTable = $('#applicants-table').DataTable({
        paging: true,
        pageLength: 10,
        lengthChange: false,
        info: true,
        language: {
            search: "Rechercher : ",
            paginate: {
                next: "Suivant",
                previous: "Précédent"
            },
            info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            lengthMenu: "Afficher _MENU_ entrées",
            loadingRecords: "Chargement...",
            infoEmpty: 'Aucun candidat jusque-là ! ',
            zeroRecords: 'Aucun candidat trouvé, désolé !',
        },
        layout: {
            topStart: {
                buttons: ['copy', 'excel', 'pdf', 'print']
            },
            top1: {
                searchPanes: {
                    viewTotal: true,
                }
            }
        },
        columnDefs: [
            {
                // orderable: false,
                searchPanes: {
                    show: false,
                },
                targets: [0]
            },
        ],
    });
})


document.addEventListener("DOMContentLoaded", () => {
    setupModal();
    const gridViewBtn = document.getElementById("gridViewBtn");
    const listViewBtn = document.getElementById("listViewBtn");
    const gridView = document.getElementById("gridView");
    const listView = document.getElementById("listView");
    const loadingPlaceholders = document.getElementById('loadingPlaceholders');

    // Restaurer la vue précédemment sélectionnée
    const savedView = localStorage.getItem('selectedView') || 'grid';
    switchView(savedView);

    // Gestionnaires d'événements pour les boutons
    gridViewBtn.addEventListener("click", () => switchView('grid'));
    listViewBtn.addEventListener("click", () => switchView('list'));

    // Infinite scroll for grid view
    const grid = document.getElementById('applicantsGrid');
    const loadMoreContainer = document.getElementById('load-more-container');

    // Search functionality
    const searchModalButton = document.getElementById('searchModalButton');
    const searchModal = document.getElementById('searchModal');
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const noResults = document.getElementById('noResults');
    let searchTimeout;
    // Search input event listener
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            const query = e.target.value.trim();
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                noResults.classList.add('hidden');
                return;
            }
            searchTimeout = setTimeout(() => {
                searchApplicants(query);
            }, 300);
        });
    }

    // Initialize modals
    const modals = document.querySelectorAll('[data-modal-toggle]');
    modals.forEach(button => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-modal-toggle');
            const modal = document.getElementById(target);
            modal.classList.toggle('hidden');
        });
    });
    // Close modals when clicking outside
    window.addEventListener('click', (e) => {
        modals.forEach(button => {
            const target = button.getAttribute('data-modal-toggle');
            const modal = document.getElementById(target);
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
});

let isLoading = false;
let isScrolling = false;
let nextPageUrl = '{{ $gridApplicants->nextPageUrl() }}';
window.addEventListener('scroll', () => {
    if (isScrolling) return;

    isScrolling = true;
    const {
        scrollTop,
        scrollHeight,
        clientHeight
    } = document.documentElement;

    if (!gridView.classList.contains('hidden') && scrollTop + clientHeight >= scrollHeight - 50) {
        loadMoreApplicants();
    }

    setTimeout(() => {
        isScrolling = false;
    }, 100);
}, {
    passive: true
});


document.addEventListener('click', function (e) {
    const toggleBtn = e.target.closest('[data-scholarship-dropdown]');
    const isInsideDropdown = e.target.closest('.scholarship-dropdown-menu');

    if (toggleBtn) {
        e.preventDefault();
        e.stopPropagation();

        const dropdownId = toggleBtn.getAttribute('data-scholarship-dropdown');
        const dropdown = document.getElementById(dropdownId);

        if (!dropdown) return;

        document.querySelectorAll('.scholarship-dropdown-menu').forEach(menu => {
            if (menu !== dropdown) {
                menu.classList.add('hidden');
            }
        });

        dropdown.classList.toggle('hidden');

        if (window.lucide) {
            window.lucide.createIcons({icons: window.lucide.icons});
        }

        return;
    }

    if (!isInsideDropdown) {
        document.querySelectorAll('.scholarship-dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});

function setupModal() {
    const modal = document.getElementById('searchModal');
    const modalBackdrop = document.getElementById('modalBackdrop');
    const closeModal = document.getElementById('closeModal');
    const searchModalButton = document.getElementById('searchModalButton');

    function openModal() {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModalHandler() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    if (searchModalButton) {
        searchModalButton.addEventListener('click', openModal);
    }
    if (closeModal) {
        closeModal.addEventListener('click', closeModalHandler);
    }
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', closeModalHandler);
    }
}

function displaySearchResults(results) {
    const resultsContainer = document.querySelector('#searchResults ul');
    resultsContainer.innerHTML = '';
    if (results.length === 0) {
        noResults.classList.remove('hidden');
        searchResults.classList.add('hidden');
        return;
    }
    noResults.classList.add('hidden');

    results.forEach(applicant => {
        const li = document.createElement('li');
        let url = '';
        url = url.replace(':id', applicant.id);
        li.className = 'p-3 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer';
        li.innerHTML = `
                        <a href="${url}" class="block">
                            <div class="font-medium text-gray-900 dark:text-white">
                                ${applicant.first_name} ${applicant.last_name}
                            </div>
                            <div class="text-gray-500 dark:text-gray-400 text-sm">
                                ${applicant.registration_code ? '• ' + applicant.registration_code : ''}
                            </div>
                        </a>
                    `;
        resultsContainer.appendChild(li);
    });
    searchResults.classList.remove('hidden');
}

// Search applicants function
async function searchApplicants(query) {
    try {
        const response = await fetch(
            '', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                query
            })
        });
        const results = await response.json();
        displaySearchResults(results);
    } catch (error) {
        console.error('Error searching applicants:', error);
    }
}

// Load more applicants function
async function loadMoreApplicants() {
    if (isLoading || !nextPageUrl) return;

    isLoading = true;
    loadingPlaceholders.classList.remove('hidden');

    try {
        const response = await fetch(nextPageUrl + '&ajax=1');
        const data = await response.json();

        if (data.html) {
            const temp = document.createElement('div');
            temp.innerHTML = data.html;
            const newItems = temp.querySelectorAll('.card');

            newItems.forEach(item => {
                if (gridView.classList.contains('hidden')) {
                    return;
                } else {
                    document.getElementById('applicantsGrid').appendChild(item);
                    lucide.createIcons({icons: lucide.icons});
                }
            });

            nextPageUrl = data.next_page_url;
            if (!nextPageUrl) {
                document.getElementById('load-more-container')?.remove();
            }
        }
    } catch (error) {
        console.error('Error loading more applicants:', error);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'col-span-1 md:col-span-2 xl:col-span-4 text-center p-4 text-red-500';
        errorDiv.textContent = 'Erreur lors du chargement des candidats. Veuillez réessayer.';
        document.getElementById('applicantsGrid').appendChild(errorDiv);
    } finally {
        isLoading = false;
        loadingPlaceholders.classList.add('hidden');
    }
}

// Fonction pour changer la vue
function switchView(view) {
    if (view === 'grid') {
        gridView.classList.remove("hidden");
        listView.classList.add("hidden");
        gridViewBtn.classList.add("active");
        listViewBtn.classList.remove("active");
        localStorage.setItem('selectedView', 'grid');
    } else {
        listView.classList.remove("hidden");
        gridView.classList.add("hidden");
        listViewBtn.classList.add("active");
        gridViewBtn.classList.remove("active");
        localStorage.setItem('selectedView', 'list');

        const url = new URL(window.location.href);
        url.searchParams.set('view', 'list');
        // window.location.href = url.toString();
    }
}

function extractTextFromImage(certificateUrl, candidatId) {
    const pourcentageMessage = document.getElementById('pourcentageMessage' + candidatId);
    const progressIndicator = document.getElementById('progressIndicator' + candidatId);

    // Affiche l'indicateur de progression
    progressIndicator.style.display = 'block';
    progressIndicator.innerHTML = 'Vérification en cours : 0%';
    pourcentageMessage.innerText = '';

    Tesseract.recognize(
        certificateUrl,
        'eng', // Langue d'analyse
        {
            logger: (m) => {
                if (m.status === 'recognizing text') {
                    const progress = Math.round(m.progress * 100);
                    progressIndicator.innerHTML = `Vérification en cours : ${progress}%`;
                }
            }
        }
    ).then(({
        data: {
            text
        }
    }) => {
        // Masque l'indicateur de progression
        progressIndicator.style.display = 'none';

        // Recherche de la mention "AVEC XX % DES POINTS" dans le texte extrait
        const match = text.match(/(\d[\d\s\[\]]*)\s*%\s*DES\s*POINTS/i);

        if (match && match[1]) {
            const pourcentage = parseInt(match[1], 10);

            pourcentageMessage.innerText =
                `Le candidat a obtenu un pourcentage de ${pourcentage}%.`;

        } else {
            pourcentageMessage.innerText =
                "Le pourcentage n'a pas pu être détecté sur l'attestation.";
        }
    }).catch((err) => {
        // Masque l'indicateur de progression et affiche un message d'erreur
        progressIndicator.style.display = 'none';
        pourcentageMessage.innerText = 'Erreur lors de la reconnaissance du texte.';
        console.error(err);
    });
}

function showIdentity(identityUrl, candidatId, name, isPDF) {
    let contentHtml;

    if (isPDF) {
        contentHtml = `
                        <div>
                            <iframe id="IdentityIframe${candidatId}" src="${identityUrl}"
                                    style="width: 1000px; height: 400px;" frameborder="0"></iframe>
                        </div>
                    `;
    } else {
        contentHtml = `
                        <div>
                            <img id="identityImage${candidatId}" src="${identityUrl}" alt="Piece d'identite" class="w-full h-48 object-cover">
                        </div>
                    `;
    }
    Swal.fire({
        title: `Pièce d\'identité de ${name}`,
        html: `
                        ${contentHtml}
                        `,
        showCloseButton: true,
        focusConfirm: false,
        confirmButtonText: 'Fermer',
        customClass: {
            popup: 'custom-swal'
        }
    });
}