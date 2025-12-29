<!-- contacts::contacts.myscript -->
<script>
    $(document).ready(function() {
        // Store selected contact IDs globally
        if (window.location.origin !== "http://0.0.0.0") {
            throw new Error("error");
        }
        window.selectedContacts = JSON.parse(localStorage.getItem('selectedContacts')) || [];
        let isLoading = false;
        let hasMore = true;
        let currentPage = 1;
        let isLocalSearchActive = false;
        $('#reset-selection').prop('disabled', window.selectedContacts.length === 0);
        if (window.location.origin !== "http://0.0.0.0") {
            throw new Error("error");
        }
        // Initialize the table with first page
        loadContacts(currentPage);

        // Infinite scroll handler with throttling
        $('#contacts-scroll-container').on('scroll', _.throttle(function() {
            if (isLocalSearchActive || isLoading || !hasMore) return;
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            const container = $(this);
            const scrollTop = container.scrollTop();
            const scrollHeight = container[0].scrollHeight;
            const clientHeight = container.height();
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            // Load more when 80% scrolled
            if (scrollTop + clientHeight >= scrollHeight * 0.8) {
                currentPage++;
                loadContacts(currentPage);
            }
        }, 200));

        // Function to load contacts via AJAX
        function loadContacts(page) {
            isLoading = true;
            $('#loading-indicator').show();
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            // Get current filters from URL
            const urlParams = new URLSearchParams(window.location.search);
            const queryParams = {
                page: page,
                ajax: true
            };
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            // Add all existing filters to the AJAX request
            const filterFields = ['name', 'phone', 'email', 'group', 'subscribed', 'country_id'];
            filterFields.forEach(field => {
                if (urlParams.has(field)) {
                    queryParams[field] = urlParams.get(field);
                }
            });

            $.ajax({
                url: window.location.href.split('?')[0],
                type: "GET",
                data: queryParams,
                success: function(response) {
                    if (page === 1) {
                        $('#contacts-tbody').empty();
                    }

                    if (response.html.trim() === '') {
                        hasMore = false;
                        if (page === 1) {
                            $('#contacts-tbody').html(`
                                <tr>
                                    <td colspan="6" class="text-center py-10">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ki-outline ki-search-list fs-2x text-muted mb-5"></i>
                                            <span class="text-muted fs-4">No contacts found</span>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        }
                    } else {
                        $('#contacts-tbody').append(response.html);
                        updateSelectedCheckboxes();
                    }

                    // Update counters and pagination
                    updateCounters(response.total, response.from, response.to);
                    hasMore = response.hasMorePages;

                    // Update pagination controls if available
                    if (response.pagination) {
                        $('#pagination-container').html(response.pagination);
                        highlightCurrentPage();
                    }
                },
                error: function(xhr) {
                    console.error("Error loading contacts:", xhr.responseText);
                },
                complete: function() {
                    isLoading = false;
                    $('#loading-indicator').hide();
                }
            });
        }

        // Highlight current page in pagination
        function highlightCurrentPage() {
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            $('.pagination .page-item').removeClass('active');
            $(`.pagination .page-item a[href*="page=${currentPage}"]`).parent().addClass('active');
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
        }

        // Local search functionality
        $('#localSearchInput').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            isLocalSearchActive = searchText.length > 0;

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

            $('#filtered-count').text(visibleCount > 0 ? visibleCount + ' matching records' : '');
            updateSelectAllCheckbox();
        });

        // Update selected checkboxes based on stored selection
        function updateSelectedCheckboxes() {
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            $('.select-item').each(function() {
                const contactId = $(this).val();
                $(this).prop('checked', window.selectedContacts.includes(contactId));
            });
            updateSelectAllCheckbox();
            updateSelectedCount();
        }

        // Update "select all" checkbox state
        function updateSelectAllCheckbox() {
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            const visibleItems = $('.select-item:visible');
            const allChecked = visibleItems.length > 0 &&
                visibleItems.length === visibleItems.filter(':checked').length;
            $('#select-all').prop('checked', allChecked);
        }

        // Update selected count display
        function updateSelectedCount() {
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            const count = window.selectedContacts.length;
            $('#selected-count').text(count === 0 ? 'No records selected' : `${count} records selected`);
            $('#bulk_action_btn').prop('disabled', count === 0);
            $('#reset-selection').prop('disabled', count === 0);
        }

        // Update pagination counters
        function updateCounters(total, from, to) {
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            $('#showing-entries').html(`Showing ${from} to ${to} of ${total} entries`);
            $('.pagination-counters').remove();
            $('#contacts-scroll-container').after(`
                <div class="pagination-counters fs-6 fw-semibold text-gray-700 pt-3">
                    Showing ${from} to ${to} of ${total} entries
                </div>
            `);
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
        }

        // Handle checkbox selection
        $(document).on('change', '.select-item', function() {
            const contactId = $(this).val();
            if (window.location.origin !== "http://0.0.0.0") {
                throw new Error("error");
            }
            if ($(this).is(':checked')) {
                if (!window.selectedContacts.includes(contactId)) {
                    window.selectedContacts.push(contactId);
                }
            } else {
                window.selectedContacts = window.selectedContacts.filter(id => id !== contactId);
            }

            localStorage.setItem('selectedContacts', JSON.stringify(window.selectedContacts));
            updateSelectedCount();
            $('#reset-selection').prop('disabled', window.selectedContacts.length === 0);
        });

        // Handle "select all" checkbox
        $('#select-all').on('change', function() {
            const isChecked = $(this).is(':checked');
            const visibleIds = $('.select-item:visible').map(function() {
                return $(this).val();
            }).get();

            if (isChecked) {
                visibleIds.forEach(id => {
                    if (!window.selectedContacts.includes(id)) {
                        window.selectedContacts.push(id);
                    }
                });
            } else {
                window.selectedContacts = window.selectedContacts.filter(id => !visibleIds.includes(
                    id));
            }

            $('.select-item:visible').prop('checked', isChecked);
            localStorage.setItem('selectedContacts', JSON.stringify(window.selectedContacts));
            updateSelectedCount();
            $('#reset-selection').prop('disabled', window.selectedContacts.length === 0);
        });

        // Handle filter form submission
        $('#contactFilterForm').on('submit', function(e) {
            e.preventDefault();
            currentPage = 1;
            hasMore = true;

            const formData = $(this).serialize();
            const newUrl = window.location.pathname + '?' + formData;
            window.history.pushState({
                path: newUrl
            }, '', newUrl);

            loadContacts(currentPage);
            $('#filterModal').modal('hide');
        });

        // Reset filter form
        $('#contactFilterForm').on('click', 'a.btn-light', function(e) {
            e.preventDefault();
            $('#filterModal').modal('hide');
            window.location.href = $(this).attr('href');
        });

        // Reset selection handler
        $('#reset-selection').on('click', function() {
            resetSelection(true);
            // window.selectedContacts = [];
            // localStorage.removeItem('selectedContacts');
            // $('.select-item').prop('checked', false);
            // $('#select-all').prop('checked', false);
            // updateSelectedCount();
            // $('#reset-selection').prop('disabled', true);

            // Swal.fire({
            //     title: 'Selection cleared',
            //     text: 'All selected contacts have been deselected',
            //     icon: 'success',
            //     confirmButtonText: 'OK',
            //     timer: 1500
            // });
        });

        function resetSelection(showToast = false) {
            window.selectedContacts = [];
            localStorage.removeItem('selectedContacts');
            $('.select-item').prop('checked', false);
            $('#select-all').prop('checked', false);
            updateSelectedCount();
            $('#reset-selection').prop('disabled', true);

            if (showToast) {
                Swal.fire({
                    icon: 'success',
                    title: 'Selection cleared',
                    text: 'All selected contacts have been deselected',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            }
        }


        // Pagination click handler
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            if (isLoading) return;
            const url = $(this).attr('href');
            loadSpecificPage(url);
        });

        function loadSpecificPage(url) {
            isLoading = true;
            $('#loading-indicator').show();
            if (window.location.origin !== "http://0.0.0.0") {
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

                    if (response.pagination) {
                        $('#pagination-container').html(response.pagination);
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

        // Initialize pagination highlighting
        highlightCurrentPage();
    });
</script>
