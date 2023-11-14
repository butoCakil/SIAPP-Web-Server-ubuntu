<?php
$subDir = 2;
include "../../../beranda/app/get_user.php";
if (@$_SESSION['level_login'] == 'superadmin') {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Real-time Log Viewer</title>
        <style>
            body {
                font-family: monospace;
                margin: 0;
                padding: 0;
                overflow: hidden;
                /* Menyembunyikan scrollbar utama */
            }

            h1 {
                background-color: #333;
                color: #fff;
                padding: 10px;
                margin: 0;
            }

            #log-container {
                max-height: 90vh;
                /* Maksimalkan tinggi container sesuai tinggi layar */
                overflow-y: auto;
                padding: 5px;
                /* Mengurangi padding */
                background-color: #000;
                color: #fff;
                white-space: pre-wrap;
                margin: 0;
                line-height: 1;
                /* Menyesuaikan nilai line-height */
            }

            #log-container .log-line {
                border-bottom: 1px solid #111;
                /* Menambahkan garis pada setiap baris */
                padding: 5px 0;
                /* Menyesuaikan padding pada setiap baris */
            }

            #log-container .highlight {
                font-weight: bold;
                color: deepskyblue;
            }

            /* Menyesuaikan scrollbar untuk browser WebKit (Chrome, Safari) */
            #log-container::-webkit-scrollbar {
                width: 10px;
            }

            #log-container::-webkit-scrollbar-thumb {
                background-color: #888;
                border-radius: 5px;
            }

            #log-container::-webkit-scrollbar-track {
                background-color: #f4f4f4;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>

    <body>

        <h1>Real-time Log Viewer</h1>
        <div id="log-container"></div>

        <script>
            $(document).ready(function() {
                var currentLogLength = 0;

                function formatLogLine(line) {
                    // Menyoroti teks yang diapit oleh tanda kurung siku []
                    return line.replace(/\[([^\]]+)\]/g, '<span class="highlight">[$1]</span>');
                }

                function fetchLog() {
                    $.ajax({
                        url: 'get_log.php',
                        success: function(data) {
                            var newLogLength = data.length;

                            if (newLogLength !== currentLogLength) {
                                // Wrap each formatted line in a div with the class 'log-line'
                                var formattedData = data.split('\n').map(function(line) {
                                    return '<div class="log-line">' + formatLogLine(line) + '</div>';
                                }).join('');

                                $('#log-container').html(formattedData);
                                $('#log-container').scrollTop($('#log-container')[0].scrollHeight);
                                currentLogLength = newLogLength;
                            }
                        },
                        complete: function() {
                            setTimeout(fetchLog, 1000);
                        }
                    });
                }

                fetchLog();
            });
        </script>

    </body>

    </html>

<?php } else { ?>
    <script>
        window.location.href = "../../../";
    </script>
<?php } ?>