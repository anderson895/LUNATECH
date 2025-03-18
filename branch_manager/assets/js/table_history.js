$(document).ready(function () {
    let currentPage = 1;
    const recordsPerPage = 10;

    function fetchHistory() {
        let searchQuery = $("#searchInput").val();

       
        $.ajax({
            url: 'backend/end-points/history_list.php',
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

                $("#historyTable tbody").html(data.table);
                updatePagination(data.totalPages);

            },
            error: function () {
                console.error("Failed to fetch branch list.");
            }
        });
    }

    // Search Filtering 
    $("#searchInput").on("keyup", function () {
        currentPage = 1;
        fetchHistory();
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
        fetchHistory();
    });

   

    // Auto-refresh every 5 seconds
    setInterval(fetchHistory, 5000);

    // Initial fetch
    fetchHistory();
});
