                <link href="<?php base_url() ?>css/dashboard.css" rel="stylesheet">
                <main>
                    <div class="indices-container">
                        <div class="corteMasPedido">
                            <div class="conteinerCorte" id="corte">
                                
                            </div>
                        </div>

                        <div class="BarberiaMasPedido">
                            <div class="conteinerBarberia" id="barberia">
                            </div>
                        </div>

                        <div class="BarberoMasPedido">
                            <div class="conteinerBarbero" id="barbero">
                            </div>
                        </div>
                    </div>

                    <div class="indices-charts">
                        <div class="barbero-chart_container">
                            <div id="chart_barbero">
                            </div>
                        </div>

                        <div class="corte-chart_container">
                            <div id="chart_Corte">
                            </div>
                        </div>

                        <div class="barberia-chart_container">
                            <div id="chart_barberia">
                            </div>
                        </div>
                    </div>

                </main>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script>
                    function graficar() {
                        $.ajax({ //iniciar ajax para crar token   
                            url: "http://api.kikosbarbershop.online/public/conteo_barberos",
                            data: {},
                            type: "GET",
                            dataType: "json",
                            headers: {
                                token: localStorage.getItem("token")
                            }
                        }).done(function(data, textStatus, jqXHR) {
                            GraficarBarbero(data);
                        });

                        function GraficarBarbero(data) {
                            google.charts.load('current', {
                                packages: ['corechart', 'bar']
                            });
                            google.charts.setOnLoadCallback(drawBasic);

                            function drawBasic() {

                                var grafic = new google.visualization.DataTable();
                                grafic.addColumn('string', 'nombre');
                                grafic.addColumn('number', 'total');
                                $.each(data.barberos, function(i, jsonData) {
                                    console.log(jsonData)
                                    var nombre = jsonData.barbero.nombre;
                                    var total = parseInt(jsonData.total);
                                    grafic.addRows([
                                        [nombre, total]
                                    ]);
                                });
                                var options = {
                                    colors: ['#4cc7c2'],
                                    title: 'Barberos solicitado en la Cita',
                                    hAxis: {
                                        title: 'Barberos',
                                        viewWindow: {
                                            min: [7, 30, 0],
                                            max: [17, 30, 0]
                                        }
                                    },
                                    vAxis: {
                                        title: 'Total de veces solicitado',
                                    }
                                    
                                };
                                var chart = new google.visualization.ColumnChart(
                                    document.getElementById('chart_barbero'));

                                chart.draw(grafic, options);
                            }
                        }


                        $.ajax({ //iniciar ajax para crar token   
                            url: "http://api.kikosbarbershop.online/public/conteo_barberias",
                            data: {},
                            type: "GET",
                            dataType: "json",
                            headers: {
                                token: localStorage.getItem("token")
                            }
                        }).done(function(data, textStatus, jqXHR) {
                            GraficarBarberia(data);
                        });

                        function GraficarBarberia(data) {
                            google.charts.load('current', {
                                packages: ['corechart', 'bar']
                            });
                            google.charts.setOnLoadCallback(drawBasic);

                            function drawBasic() {
                                var grafic = new google.visualization.DataTable();
                                grafic.addColumn('string', 'nombre');
                                grafic.addColumn('number', 'total');
                                $.each(data.barberias, function(i, jsonData) {
                                    console.log(jsonData)
                                    var nombre = jsonData.barberia.nombre;
                                    var total = parseInt(jsonData.total);
                                    grafic.addRows([
                                        [nombre, total]
                                    ]);
                                });
                                var options = {
                                    colors: ['#4cc7c2'],
                                    title: 'Barberias solicitado en la Cita',
                                    hAxis: {
                                        title: 'Barberias',
                                        viewWindow: {
                                            min: [7, 30, 0],
                                            max: [17, 30, 0]
                                        }
                                    },
                                    vAxis: {
                                        title: 'Total de veces solicitado'
                                    }
                                };
                                var chart = new google.visualization.ColumnChart(
                                    document.getElementById('chart_barberia'));

                                chart.draw(grafic, options);
                            }
                        }

                        $.ajax({ //iniciar ajax para crar token   
                            url: "http://api.kikosbarbershop.online/public/conteo_cortes",
                            data: {},
                            type: "GET",
                            dataType: "json",
                            headers: {
                                token: localStorage.getItem("token")
                            }
                        }).done(function(data, textStatus, jqXHR) {
                            GraficarCorte(data);
                        });

                        function GraficarCorte(data) {
                            google.charts.load('current', {
                                packages: ['corechart', 'bar']
                            });
                            google.charts.setOnLoadCallback(drawBasic);

                            function drawBasic() {
                                var grafic = new google.visualization.DataTable();
                                grafic.addColumn('string', 'nombre');
                                grafic.addColumn('number', 'total');
                                $.each(data.cortes, function(i, jsonData) {
                                    console.log(jsonData)
                                    var nombre = jsonData.corte.nombre;
                                    var total = parseInt(jsonData.total);
                                    grafic.addRows([
                                        [nombre, total]
                                    ]);
                                });
                                var options = {
                                    colors: ['#4cc7c2'],
                                    title: 'Cortes solicitado en la Cita',
                                    hAxis: {
                                        title: 'Cortes',
                                        viewWindow: {
                                            min: [7, 30, 0],
                                            max: [17, 30, 0]
                                        }
                                    },
                                    vAxis: {
                                        title: 'Total de veces solicitado'
                                    }
                                };
                                var chart = new google.visualization.ColumnChart(
                                    document.getElementById('chart_Corte'));

                                chart.draw(grafic, options);
                            }
                        }
                    }
                    graficar()

                    $.ajax({ //iniciar ajax para crar token   
                            url: "http://api.kikosbarbershop.online/public/corte_mas_pedido",
                            data: {},
                            type: "GET",
                            dataType: "json",
                            headers: {
                                token: localStorage.getItem("token")
                            }
                        })
                        .done(function(data, textStatus, jqXHR) {
                            $("#corte").html('<h3 style="color: white;">Corte m??s pedido</h3> <label class="nombre">'+ data.nombre +'</label> <img class="visualizacion" src="'+data.visualizacion+'"/>');
                        });

                        $.ajax({ //iniciar ajax para crar token   
                            url: "http://api.kikosbarbershop.online/public/barberia_mas_pedido",
                            data: {},
                            type: "GET",
                            dataType: "json",
                            headers: {
                                token: localStorage.getItem("token")
                            }
                        })
                        .done(function(data, textStatus, jqXHR) {
                            $("#barberia").html('<h3 style="color: white;">Barberia con m??s citas</h3> <label class="nombre">'+ data.nombre +'</label> <img class="visualizacion" src="'+data.visualizacion+'"/>');
                        });

                        $.ajax({ //iniciar ajax para crar token   
                            url: "http://api.kikosbarbershop.online/public/barbero_mas_pedido",
                            data: {},
                            type: "GET",
                            dataType: "json",
                            headers: {
                                token: localStorage.getItem("token")
                            }
                        })
                        .done(function(data, textStatus, jqXHR) {
                            $("#barbero").html('<h3 style="color: white;">Barbero m??s solicitado</h3> <label class="nombre">'+ data.nombre +'</label> <img class="visualizacion" src="'+data.visualizacion+'"/>');
                        });

                        $('#chart_barbero').dataTable( {
                            "drawCallback": function( settings ) {
                                $('ul.pagination').addClass("pagination-sm");
                            }
                        });
                </script>