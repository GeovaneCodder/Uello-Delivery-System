$(document).ready(function() {
    var $fileInput = $('.file-input');
    var $droparea = $('.file-drop-area');
    var $countFile = 0;

    $fileInput.on('dragenter focus click', function() {
        $droparea.addClass('is-active');
    });

    $fileInput.on('dragleave blur drop', function() {
        $droparea.removeClass('is-active');
    });

    $fileInput.on('change', function() {
        var $textContainer = $(this).prev();
        var fileName = $(this).val().split('\\').pop();
        $textContainer.text(fileName);
        $countFile = 1;
    });

    $('#submitForm').on( 'submit', function( event ) {
        event.preventDefault();
        $('.alert-text').html('');
        $('.modal').modal('hide');
        $('.loading').css('display', 'block');

        let form = new FormData();

        if( $countFile > 0 ) {
            form.append( 'csv_file', $fileInput[0].files[0] );
        }
        else {
            $('.alert-text').html('Selecione um arquivo.');
            $('.alert-danger').css('display', 'block');
            $('.modal').modal( 'hide' );
            $('.loading').hide();
            return;
        }

        $countFile = 0;

        axios({
            method: 'post',
            url: '/upload',
            data: form
        })
        .then(response => {
            console.log(response);
            let message = response.message;
            $('.alert-text').html(message);
            $('.alert-success').css('display', 'block');
            $('.loading').hide();
            $(location).attr('href', '/list');
        })
        .catch(e => {
            let response = e.response.data.message;
            $('.alert-text').html(response);
            $('.alert-danger').css('display', 'block');
            $('.loading').hide();
            return;
        });
    });

    $('.goToList').click(function(){
        $(location).attr('href', '/list');
    });

    function exportTableToCSV($table, filename) {
        var $rows = $table.find('tr:has(td)'),
            tmpColDelim = String.fromCharCode(11),
            tmpRowDelim = String.fromCharCode(0),
            colDelim = '","',
            rowDelim = '"\r\n"',
            csv = '"' + $rows.map(function (i, row) {
                var $row = $(row),
                    $cols = $row.find('td');

                return $cols.map(function (j, col) {
                    var $col = $(col),
                        text = $col.text();
                    return text.replace(/"/g, '""');
                }).get().join(tmpColDelim);

            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"';
            
            if (false && window.navigator.msSaveBlob) {
                var blob = new Blob([decodeURIComponent(csv)], {
                type: 'text/csv;charset=utf8'
            });

            window.navigator.msSaveBlob(blob, filename);
            
        } else if (window.Blob && window.URL) {
            var blob = new Blob([csv], { type: 'text/csv;charset=utf8' });
            var csvUrl = URL.createObjectURL(blob);
            $(this)
            		.attr({
                		'download': filename,
                		'href': csvUrl
		            });
				} else {
            var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
            $(this).attr({
                'download': filename,
                'href': csvData,
                'target': '_blank'
            });
        }
    }

    $(".a-export").on('click', function (event) {
        var args = [$('.table'), 'export.csv'];
        exportTableToCSV.apply(this, args);
    });
});

function openModal ( lat, long ) {
    var directionsDisplay = new google.maps.DirectionsRenderer();
    var directionsService = new google.maps.DirectionsService();

    var mapOptions = {
        center: new google.maps.LatLng('-23.529032','-46.7397648'),
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    
    var map = new google.maps.Map( document.getElementById("mapa"), mapOptions );

    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('directionsPanel'));

    var request = {
        origin: new google.maps.LatLng('-23.529032','-46.7397648'),
        destination: new google.maps.LatLng(lat,long),
        travelMode: 'DRIVING'
    };
    
    directionsService.route(request, function(response, status) {
        if (status == 'OK') {
            directionsDisplay.setDirections(response);
        }
    });
}