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


    function exportTableToCSV($table, filename) {

        var $rows = $table.find('tr:has(td)'),

            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0), // null character

            // actual delimiter characters for CSV format
            colDelim = '","',
            rowDelim = '"\r\n"',

            // Grab text from table into CSV formatted string
            csv = '"' + $rows.map(function (i, row) {
                var $row = $(row),
                    $cols = $row.find('td');

                return $cols.map(function (j, col) {
                    var $col = $(col),
                        text = $col.text();

                    return text.replace(/"/g, '""'); // escape double quotes

                }).get().join(tmpColDelim);

            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"';

				// Deliberate 'false', see comment below
        if (false && window.navigator.msSaveBlob) {

						var blob = new Blob([decodeURIComponent(csv)], {
	              type: 'text/csv;charset=utf8'
            });
            
            // Crashes in IE 10, IE 11 and Microsoft Edge
            // See MS Edge Issue #10396033: https://goo.gl/AEiSjJ
            // Hence, the deliberate 'false'
            // This is here just for completeness
            // Remove the 'false' at your own risk
            window.navigator.msSaveBlob(blob, filename);
            
        } else if (window.Blob && window.URL) {
						// HTML5 Blob        
            var blob = new Blob([csv], { type: 'text/csv;charset=utf8' });
            var csvUrl = URL.createObjectURL(blob);

            $(this)
            		.attr({
                		'download': filename,
                		'href': csvUrl
		            });
				} else {
            // Data URI
            var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

						$(this)
                .attr({
               		  'download': filename,
                    'href': csvData,
                    'target': '_blank'
            		});
        }
    }

    // This must be a hyperlink
    $(".a-export").on('click', function (event) {
        // CSV
        var args = [$('.table'), 'export.csv'];
        
        exportTableToCSV.apply(this, args);
        
        // If CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
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