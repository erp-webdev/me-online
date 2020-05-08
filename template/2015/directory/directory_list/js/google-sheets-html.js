google.load('visualization', '1', {
    packages: ['table']
});
var visualization;

function drawVisualization() {
    var query = new google.visualization.Query('https://docs.google.com/spreadsheets/d/1mFzaZj6lMDK8RrLNavyxNfUXENBghnGZ0dvyp7VwGCQ/edit?usp=sharing');
    query.setQuery('SELECT A, B, C, D, E, F, G label A "", B "", C "", D "", E "", F "", G ""');
    query.send(handleQueryResponse);
}

function handleQueryResponse(response) {
    if (response.isError()) {
        alert('There was a problem with your query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
        return;
    }
    var data = response.getDataTable();
    visualization = new google.visualization.Table(document.getElementById('table'));
    visualization.draw(data, {
        allowHtml: true,
        legend: 'bottom'
    }); 
}
google.setOnLoadCallback(drawVisualization);
