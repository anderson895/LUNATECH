$(document).ready(function () {
    let currentPage = 1;
    const recordsPerPage = 100;

    function fetchBranches() {
        let searchQuery = $("#searchInput").val();

        // Store checked branch IDs before refresh
        let checkedBranches = [];
        $(".rowCheckbox:checked").each(function () {
            checkedBranches.push($(this).closest("tr").find(".togglerDeleteBranch").data("branch_id"));
        });

        $.ajax({
            url: 'backend/end-points/branch_list.php',
            type: 'GET',
            data: { search: searchQuery, page: currentPage, limit: recordsPerPage },
            success: function (response) {
                let data;
                try {
                    data = JSON.parse(response);
                } catch (e) {
                    console.error("Invalid JSON response:", response);
                    return;
                }

                $("#userTable tbody").html(data.table);
                updatePagination(data.totalPages);

                // Restore checked states after refresh
                $(".rowCheckbox").each(function () {
                    let branchId = $(this).closest("tr").find(".togglerDeleteBranch").data("branch_id");
                    if (checkedBranches.includes(branchId)) {
                        $(this).prop("checked", true);
                    }
                });

                // Check 'Check All' if all rows are checked
                $("#checkAll").prop("checked", $(".rowCheckbox").length > 0 && $(".rowCheckbox:checked").length === $(".rowCheckbox").length);
            },
            error: function () {
                console.error("Failed to fetch branch list.");
            }
        });
    }

    // Search Filtering
    $("#searchInput").on("keyup", function () {
        currentPage = 1;
        fetchBranches();
    });

    // Pagination Controls
    function updatePagination(totalPages) {
        let paginationHtml = "";
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `<button class="pagination-btn ${i === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200'} px-3 py-1 rounded-md" data-page="${i}">${i}</button>`;
        }
        $("#pagination").html(paginationHtml);
    }

    $(document).on("click", ".pagination-btn", function () {
        currentPage = $(this).data("page");
        fetchBranches();
    });

    // Check All Checkbox
    $("#checkAll").on("change", function () {
        $(".rowCheckbox").prop("checked", $(this).prop("checked"));
    });

    // Delete Selected Branches
    $("#deleteAllBtn").on("click", function () {
        let selectedBranches = [];
        $(".rowCheckbox:checked").each(function () {
            selectedBranches.push($(this).closest("tr").find(".togglerDeleteBranch").data("branch_id"));
        });

        if (selectedBranches.length === 0) {
            alert("Please select at least one branch to delete.");
            return;
        }

        if (!confirm("Are you sure you want to delete the selected branches?")) return;

        $.ajax({
            url: 'backend/end-points/delete_branches.php',
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify({ branchIds: selectedBranches }),
            success: function (response) {
                let data;
                try {
                    data = JSON.parse(response);
                } catch (e) {
                    console.error("Invalid JSON response:", response);
                    return;
                }

                alert(data.message);
                if (data.success) fetchBranches();
            },
            error: function () {
                console.error("Failed to delete branches.");
            }
        });
    });

    // Auto-refresh every 5 seconds
    setInterval(fetchBranches, 5000);

    // Initial fetch
    fetchBranches();
});
