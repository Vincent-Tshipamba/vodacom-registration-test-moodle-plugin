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
            // top1: {
            //     searchPanes: {
            //         viewTotal: true,
            //     }
            // }
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
    const gridViewBtn = document.getElementById("gridViewBtn");
    const listViewBtn = document.getElementById("listViewBtn");
    const gridView = document.getElementById("gridView");
    const listView = document.getElementById("listView");
    // const loadingPlaceholders = document.getElementById('loadingPlaceholders');

    // Restaurer la vue précédemment sélectionnée
    const savedView = localStorage.getItem('selectedView') || 'grid';
    switchView(savedView);

    // Gestionnaires d'événements pour les boutons
    gridViewBtn.addEventListener("click", () => switchView('grid'));
    listViewBtn.addEventListener("click", () => switchView('list'));

    // Infinite scroll for grid view
    const grid = document.getElementById('applicantsGrid');
    const loadMoreContainer = document.getElementById('load-more-container');

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

let config = document.getElementById('scholarship-config');

if (!config) {
    throw new Error('Configuration div not found !');
}

document.addEventListener('DOMContentLoaded', () => {
    const applicantsGrid = document.getElementById('applicantsGrid');
    const loadingPlaceholders = document.getElementById('loadingPlaceholders');
})
const gridSearchInput = document.getElementById('gridSearchInput');
const gridNoResults = document.getElementById('gridNoResults');

let isLoading = false;
let isScrolling = false;
let nextPageUrl = config.dataset.nextPageUrl || '';
let searchUrl = config.dataset.searchUrl || '';
let searchTimeout = null;
let currentController = null;

async function fetchApplicantsPage(url, replace = false) {
    if (isLoading || !applicantsGrid) {
        return;
    }

    if (replace && currentController) {
        currentController.abort();
    }

    currentController = new AbortController();

    isLoading = true;

    if (loadingPlaceholders) {
        loadingPlaceholders.classList.remove('hidden');
    }

    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        const html = await response.text();

        if (!response.ok) {
            throw new Error('Erreur HTTP : ' + response.status);
        }

        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        const nextGrid = doc.getElementById('applicantsGrid');

        if (!nextGrid) {
            throw new Error('Grille candidats introuvable dans la page chargée.');
        }

        const newItems = nextGrid.querySelectorAll('.card');

        if (replace) {
            applicantsGrid.innerHTML = '';
        }
        
        newItems.forEach(function (item) {
            applicantsGrid.appendChild(item);
        });

        const newConfig = doc.getElementById('scholarship-config');

        if (newConfig) {
            nextPageUrl = newConfig.dataset.nextPageUrl || '';
        } else {
            nextPageUrl = '';
        }

        if (gridNoResults) {
            if (newItems.length === 0 && replace) {
                gridNoResults.classList.remove('hidden');
            } else {
                gridNoResults.classList.add('hidden');
            }
        }

        if (window.lucide) {
            window.lucide.createIcons({icons: window.lucide.icons});
        }

    } catch (error) {
        if (error.name === 'AbortError') {
            return;
        }
        console.error('Erreur chargement candidats:', error);

        if (replace) {
            applicantsGrid.innerHTML = '';
        }

        if (gridNoResults) {
            gridNoResults.classList.remove('hidden');
            gridNoResults.textContent = 'Erreur lors de la recherche. Veuillez réessayer.';
        }

    } finally {
        isLoading = false;

        if (loadingPlaceholders) {
            loadingPlaceholders.classList.add('hidden');
        }
    }
}

function searchApplicants() {
    const query = gridSearchInput?.value || '';
    
    const url = buildSearchUrl(query, 0);

    fetchApplicantsPage(url, true);
}

function loadMoreApplicants() {
    if (isLoading || !nextPageUrl || !applicantsGrid) {
        return;
    }

    fetchApplicantsPage(nextPageUrl, false);
}

if (gridSearchInput) {
    gridSearchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(function () {
            searchApplicants();
        }, 250);
    });
}

window.addEventListener('scroll', () => {
    if (isScrolling) return;

    isScrolling = true;
    const {
        scrollTop,
        scrollHeight,
        clientHeight
    } = document.documentElement;

    if (!gridView.classList.contains('hidden') && scrollTop + clientHeight >= scrollHeight - 80) {
        loadMoreApplicants();
    }

    setTimeout(() => {
        isScrolling = false;
    }, 100);
}, {
    passive: true
});


function buildSearchUrl(query, page = 0) {
    const url = new URL(searchUrl, window.location.origin);

    url.searchParams.set('page', page);

    query = String(query || '').trim();

    if (query !== '') {
        url.searchParams.set('q', query);
    } else {
        url.searchParams.delete('q');
    }

    return url.toString();
}


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
            window.lucide.createIcons({ icons: window.lucide.icons });
        }

        return;
    }

    if (!isInsideDropdown) {
        document.querySelectorAll('.scholarship-dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});


function escapeHtml(value) {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
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