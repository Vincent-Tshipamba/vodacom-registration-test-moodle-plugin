
function showDocument(event, fileUrl, fileId, fileType, candidateId, name, isPdf) {
    event.preventDefault();

    let contentHtml;
    isPdf = isPdf === true || isPdf === '1' || isPdf === 1;

    let title;
    if (fileType === 'DIPLOMA') {
        title = `Attestation de réussite de ${name}`;
    } else if (fileType === 'PHOTO') {
        title = `Image de ${name}`;
    } else if (fileType === 'ID') {
        title = `Pièce d'identité de ${name}`;
    }

    if (isPdf) {
        contentHtml = `
            <iframe src="${fileUrl}" style="width:100%;height:65vh;" frameborder="0"></iframe>
        `;
    } else {
        contentHtml = `
            <img src="${fileUrl}" alt="${fileType}" class="w-full max-h-[65vh] object-contain">
        `;
    }
    // if the dropdown is open, close it and return
    const dropdown = document.getElementById(`dropdown-${candidateId}`);
    if (dropdown && !dropdown.classList.contains('hidden')) {
        dropdown.classList.add('hidden');
    }
    Swal.fire({
        title: title,
        html: `${contentHtml}`,
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: "Je valide le document",
        denyButtonText: "Je ne valide pas le document",
        cancelButtonText: "Fermer",
        focusConfirm: false,
        customClass: {
            popup: 'custom-swal'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            changeDocumentStatus(fileId, true);
        } else if (result.isDenied) {
            changeDocumentStatus(fileId, false);
        }
    })
}


function changeDocumentStatus(fileId, isValid) {
    const config = document.getElementById('scholarship-config');
    const changeDocumentStatusUrl = config.dataset.documentStatusUrl;
    const moodleSesskey = config.dataset.sesskey;
    const formData = new FormData();
    formData.append('sesskey', moodleSesskey);
    formData.append('id', fileId);
    formData.append('isvalid', isValid ? '1' : '0');

    fetch(changeDocumentStatusUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(response => {
            Swal.fire({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: response.success ? "success" : "error",
                title: response.message || "Opération terminée",
            });
        })
        .catch((err) => {
            console.log(err);
            Swal.fire({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: "error",
                title: "Une erreur est survenue.",
            });
        });
}

function showProfilePhoto(photoUrl, photoId, fullName) {
    Swal.fire({
        title: `Photo de ${fullName}`,
        html: `
                    <div class="flex justify-center">
                        <img src="${photoUrl}" alt="Photo de ${fullName}" class="max-h-[70vh] w-auto max-w-full rounded-2xl object-contain shadow-lg">
                    </div>
                `,
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: "La photo est valide",
        denyButtonText: "Je ne valide pas la photo",
        cancelButtonText: "Fermer",
        focusConfirm: false,
        customClass: {
            popup: 'custom-swal'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            changeDocumentStatus(photoId, true);
        } else if (result.isDenied) {
            changeDocumentStatus(photoId, false);
        }
    });
}