
document.getElementById('search').addEventListener('input', function() {
    var searchValue = this.value.toLowerCase();
    var tableRows = document.querySelectorAll('#dataTable tbody tr');

    tableRows.forEach(function(row){
        var cells = row.getElementsByTagName('td');
        var match = false;

        for (var i=0; i<cells.length; i++){
            if(cells[i].textContent.toLowerCase().indexOf(searchValue) > -1) {
                match = true;
                break;
            }
        }

        row.style.display = match ? '' : 'none';
    });
});