
</div>
<!-- /Main Wrapper -->

<!-- /Main Wrapper -->

<!-- jQuery -->
<script src="../assets/js/jquery-3.6.0.min.js"></script>



<!-- Feather Icon JS -->
<script src="../assets/js/feather.min.js"></script>

<!-- Slimscroll JS -->
<script src="../assets/js/jquery.slimscroll.min.js"></script>

<!-- Datatable JS -->
<script src="../assets/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/dataTables.bootstrap4.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="../assets/js/bootstrap.bundle.min.js"></script>

<!-- Fileupload JS -->
<script src="../assets/plugins/fileupload/fileupload.min.js"></script>


<!-- Select2 JS -->
<script src="../assets/plugins/select2/js/select2.min.js"></script>
<script src="../assets/plugins/select2/js/custom-select.js"></script>
<script src="../assets/plugins/select2/js/select2.full.js"></script>
<script src="../assets/plugins/select2/js/select2.full.min.js"></script>
<script src="../assets/plugins/select2/js/select2.min.js"></script>

<!-- Datetimepicker JS -->
<script src="../assets/js/moment.min.js"></script>
<script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

<!-- Sweetalert 2 -->
<script src="../assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="../assets/plugins/sweetalert/sweetalerts.min.js"></script>

<!-- Wizard JS -->
<script src="../assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="../assets/plugins/twitter-bootstrap-wizard/prettify.js"></script>
<script src="../assets/plugins/twitter-bootstrap-wizard/form-wizard.js"></script>

<!-- Custom JS -->
<script src="../assets/js/script.js"></script>

<script>
    $('select').selectpicker();
</script>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("La géolocalisation n'est pas prise en charge par ce navigateur.");
        }
    }

    // function showPosition(position) {
    //     document.getElementById("longitude").value = position.coords.longitude;
    //     document.getElementById("latitude").value = position.coords.latitude;
    // }
    function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // Remplir les champs de latitude et longitude
        document.getElementById("longitude").value = longitude;
        document.getElementById("latitude").value = latitude;

        // Créer l'URL Google Maps
        var googleMapUrl = "https://www.google.com/maps?q=" + latitude + "," + longitude;

        // Remplir le champ adresse_map avec l'URL
        document.getElementsByName("adresse_map")[0].value = googleMapUrl;
    }


    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("L'utilisateur a refusé la demande de géolocalisation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Les informations de localisation sont indisponibles.");
                break;
            case error.TIMEOUT:
                alert("La demande de localisation a expiré.");
                break;
            case error.UNKNOWN_ERROR:
                alert("Une erreur inconnue est survenue.");
                break;
        }
    }

</script>


<script>
    document.getElementById('pays_id').addEventListener('change', function() {
        const paysId = this.value;
        const villeSelect = document.getElementById('ville_id');
        const communeSelect = document.getElementById('commune_id');

        villeSelect.innerHTML = '<option value="">Sélectionnez une ville</option>';
        communeSelect.innerHTML = '<option value="">Sélectionnez une commune</option>';
        communeSelect.disabled = true;

        if (paysId) {
            fetch(`/get-villes/${paysId}`)
            .then(response => {
                console.log('Réponse de la requête:', response); // Ajoutez ceci pour déboguer
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Traitement des données
            })
            .catch(error => {
                console.error('Erreur lors du chargement des villes:', error);
            });

        }
    });

    document.getElementById('ville_id').addEventListener('change', function() {
        const villeId = this.value;
        const communeSelect = document.getElementById('commune_id');

        communeSelect.innerHTML = '<option value="">Sélectionnez une commune</option>';

        if (villeId) {
            fetch(`/get-communes/${villeId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erreur HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    data.forEach(commune => {
                        const option = document.createElement('option');
                        option.value = commune.id;
                        option.textContent = commune.nom;
                        communeSelect.appendChild(option);
                    });
                    communeSelect.disabled = false; // Activer le champ des communes
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des communes:', error);
                });
        }
    });
    </script>

<script>
    function confirmDelete(serviceId) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Vous ne pourrez pas revenir en arrière !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                // Si l'utilisateur confirme, soumettre le formulaire
                document.getElementById('deleteForm' + serviceId).submit();
            }
        });
    }
</script>

<script>
    function toggleDescription(itemId) {
        var descriptionShort = document.getElementById("description" + itemId);
        var descriptionFull = document.getElementById("fullDescription" + itemId);
        var showMoreBtn = document.getElementById("showMoreBtn" + itemId);

        // Toggle the description visibility
        if (descriptionFull.style.display === "none") {
            descriptionFull.style.display = "inline";
            descriptionShort.style.display = "none";
            showMoreBtn.textContent = "Voir moins";  // Change the button text to "Voir moins"
        } else {
            descriptionFull.style.display = "none";
            descriptionShort.style.display = "inline";
            showMoreBtn.textContent = "Voir plus";  // Change the button text back to "Voir plus"
        }
    }
</script>

</body>

</html>
