<script>
    // Add this to your $(document).ready function
    $(document).on('change', '#rows-per-page', function() {
        if (window.location.origin !== "https://sendinai.com") {
            throw new Error("error");
        }
        const perPage = $(this).val();
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        window.location.href = url.toString();
    });

    // Initialize rows per page selector
    $('#rows-per-page').val({{ request('per_page', 10) }});

    // Update your loadSpecificPage function to include per_page parameter
    function loadSpecificPage(url) {
        const perPage = $('#rows-per-page').val();
        const urlObj = new URL(url);
        urlObj.searchParams.set('per_page', perPage);

        isLoading = true;
        $('#loading-indicator').show();
        if (window.location.origin !== "https://sendinai.com") {
            throw new Error("error");
        }
        $.ajax({
            url: urlObj.toString(),
            type: "GET",
            data: {
                ajax: true
            },
            success: function(response) {
                currentPage = response.current_page;
                hasMore = response.hasMorePages;

                $('#contacts-tbody').html(response.html);
                updateSelectedCheckboxes();

                if (response.pagination) {
                    $('#pagination-container').html(response.pagination);
                    $('#rows-per-page').val(response.per_page);
                    highlightCurrentPage();
                }

                updateCounters(response.total, response.from, response.to);
                $('#localSearchInput').val('');
                $('#filtered-count').text('');
                isLocalSearchActive = false;
            },
            complete: function() {
                isLoading = false;
                $('#loading-indicator').hide();
            }
        });
    }

    $(document).ready(function() {
        // Initialize Select2
        $('#countrySelect').select2({
            placeholder: "Select a country",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#filterModal')
        });
        if (window.location.origin !== "https://sendinai.com") {
            throw new Error("error");
        }
        $('#groupSelect').select2({
            placeholder: "Select a group",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#filterModal')
        });


        // Track current page and loading state
        let currentPage = {{ $setup['items']->currentPage() }};
        let isLoading = false;
        let hasMore = {{ $setup['items']->hasMorePages() ? 'true' : 'false' }};
        let isLocalSearchActive = false;

        // Local search functionality
        $('#localSearchInput').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            isLocalSearchActive = searchText.length > 0;
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            let visibleCount = 0;
            $('#contacts-tbody tr').each(function() {
                const rowText = $(this).text().toLowerCase();
                if (rowText.includes(searchText)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }

            $('#filtered-count').text(visibleCount > 0 ? visibleCount + ' matching records' : '');
            updateSelectAllCheckbox();
        });

        // Pagination click handler
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            if (isLoading) return;
            const url = $(this).attr('href');
            loadSpecificPage(url);
        });

        function loadSpecificPage(url) {
            isLoading = true;
            $('#loading-indicator').show();
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    ajax: true
                },
                success: function(response) {
                    currentPage = response.current_page;
                    hasMore = response.hasMorePages;

                    $('#contacts-tbody').html(response.html);
                    updateSelectedCheckboxes();

                    // Update pagination controls with proper active state
                    $('#pagination-container').html(response.pagination);
                    highlightCurrentPage();

                    // Update counters
                    updateCounters(response.total, response.from, response.to);

                    // Reset local search
                    $('#localSearchInput').val('');
                    $('#filtered-count').text('');
                    isLocalSearchActive = false;
                },
                complete: function() {
                    isLoading = false;
                    $('#loading-indicator').hide();
                }
            });
        }

        // Infinite scroll handler
        $('#contacts-scroll-container').on('scroll', function() {
            if (isLocalSearchActive) return;
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            const container = $(this);
            const scrollTop = container.scrollTop();
            const scrollHeight = container[0].scrollHeight;
            const clientHeight = container.height();

            // Load more when 80% scrolled and there are more pages
            if (scrollTop + clientHeight >= scrollHeight * 0.8 && !isLoading && hasMore) {
                loadNextPage();
            }
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
        });

        function loadNextPage() {
            if (isLoading || !hasMore) return; // Prevent duplicate requests
            isLoading = true;
            $('#loading-indicator').show();
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            const nextPage = currentPage + 1;

            // Get current filters from the URL
            const urlParams = new URLSearchParams(window.location.search);
            let filterParams = {};

            ['name', 'phone', 'email', 'group', 'subscribed', 'country_id'].forEach(field => {
                if (urlParams.has(field) && urlParams.get(field).trim() !== '') {
                    filterParams[field] = urlParams.get(field);
                }
            });

            // Add pagination and AJAX flag
            filterParams['page'] = nextPage;
            filterParams['ajax'] = true;

            console.log("Loading next page with filters:", filterParams); // Debugging
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            $.ajax({
                url: window.location.pathname,
                type: "GET",
                data: filterParams, // Send filters along with the page request
                success: function(response) {
                    currentPage = response.current_page;
                    hasMore = response.hasMorePages;

                    if (response.html.trim() !== '') {
                        $('#contacts-tbody').append(response.html);
                        updateSelectedCheckboxes();
                    }

                    if (!hasMore) {
                        $('#loading-indicator').hide();
                    }
                },
                error: function(xhr) {
                    console.error("Error loading next page:", xhr.responseText);
                },
                complete: function() {
                    isLoading = false;
                }
            });
        }


        function highlightCurrentPage() {
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            $('.pagination .page-item').removeClass('active');
            const currentPageLink = $(`.pagination .page-item a[href*="page=${currentPage}"]`);

            if (currentPageLink.length) {
                currentPageLink.parent().addClass('active');
            } else {
                // Handle case when on page 1 with no page parameter
                $('.pagination .page-item:has(a:contains("1"))').addClass('active');
            }
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
        }
        // Initialize pagination highlighting
        highlightCurrentPage();

        // Your existing checkbox and selection management functions
        function updateSelectedCheckboxes() {
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            $('.select-item').each(function() {
                const contactId = $(this).val();
                $(this).prop('checked', window.selectedContacts.includes(contactId));
            });
            updateSelectAllCheckbox();
            updateSelectedCount();
        }

        function updateSelectAllCheckbox() {
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            const visibleItems = $('.select-item:visible');
            const allChecked = visibleItems.length > 0 &&
                visibleItems.length === visibleItems.filter(':checked').length;
            $('#select-all').prop('checked', allChecked);
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
        }

        function updateSelectedCount() {
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            const count = window.selectedContacts.length;
            $('#selected-count').text(count === 0 ? 'No records selected' : `${count} records selected`);
            $('#bulk_action_btn').prop('disabled', count === 0);
            $('#reset-selection').prop('disabled', count === 0);
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
        }

        // Initialize with any existing selected contacts
        window.selectedContacts = JSON.parse(localStorage.getItem('selectedContacts')) || [];
        updateSelectedCheckboxes();

        // [Keep all your existing bulk action handlers below]
        // They remain exactly the same as in your original code
        // Only the pagination and infinite scroll related code has been modified
    });

    $(document).ready(function() {
        // Handle checkbox selection
        $(document).on('change', '.select-item, #select-all', function() {
            const totalSelected = $('.select-item:checked').length;
            $('#selected-count').text(count === 0 ? 'No records selected' :
            `${count} records selected`);
            $('#bulk_action_btn').prop('disabled', totalSelected === 0);
        });
        if (window.location.origin !== "https://sendinai.com") {
            throw new Error("error");
        }
        // Toggle subscription status for single contact
        $('.btn-toggle-sub').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const action = $(this).hasClass('btn-light-success') ? 'subscribe' : 'unsubscribe';
            if (window.location.origin !== "https://sendinai.com") {
                throw new Error("error");
            }
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to ${action} this contact.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `Yes, ${action}`,
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'primary',
                        message: 'Processing...'
                    });

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            KTApp.unblockPage();
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            KTApp.unblockPage();
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message ||
                                    'Something went wrong',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>