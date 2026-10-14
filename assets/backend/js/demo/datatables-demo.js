$(document).ready(function() {

    var table = $('#dataTable').DataTable({
        columnDefs: [
            {
                targets: [0],
                orderable: false
            }
        ],
        order: [[1, 'asc']]
    });

    function updateNomor() {
        var info = table.page.info();

        table.rows({
            page: 'current',
            search: 'applied',
            order: 'applied'
        }).every(function(rowIdx, tableLoop, rowLoop) {
            var nomor = info.start + rowLoop + 1;

            $(this.node()).find('td:eq(0)').text(nomor + '.');
        });
    }

    table.on('draw.dt', function() {
        updateNomor();
    });

    updateNomor();

});