                <main>

                    <h1>Dashboard</h1>
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
                    <div id="chart_barbero">

                    </div>
                    <div id="chart_Corte">

                    </div>
                    <div id="chart_barberia">

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
                                    title: 'Barberos solicitado en la Cita',
                                    hAxis: {
                                        title: 'Barberos',
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
                            $("#corte").html('<label class="nombre">'+ data.nombre +'</label>');
                            $("#corte").html('<img class="visualizacion" src="'+data.visualizacion+'"/>');
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
                            $("#barberia").html('<label class="nombre">'+ data.nombre +'</label>');
                            $("#barberia").html('<img class="visualizacion" src="'+data.visualizacion+'"/>');
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
                            $("#barbero").html('<label class="nombre">'+ data.nombre +'</label>');
                            $("#barbero").html('<img class="visualizacion" src="'+data.visualizacion+'"/>');
                        });
                </script>