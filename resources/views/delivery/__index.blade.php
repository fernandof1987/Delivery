<!-- 2016-28-09 BACKUP -->
@extends('layouts.app')

@section('content')
    <style>
        #map-canvas {
            width: 100%;
            height: 600px;
        }
    </style>

    <h3>Cofema Delivey</h3>
    <div id="map-canvas"></div>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script>

        var markersData = [
                @foreach($clientes as $cliente)
                   {
                lat: {{ $cliente->latitude }},
                lng: {{ $cliente->longitude }},
                nome: '{{ $cliente->Cli_Cod }} - {{ $cliente->Cli_Nome }}',
                end: '{{ $cliente->Cle_End }}',
                status: '{{ $cliente->Cli_Status }}',
                cep: '{{ $cliente->Cle_Cep }}'
            },

                @endforeach
                {
                lat: -23.5516808,
                lng: -46.5212679,
                nome: "Cofema",
                end:"Av Arivanduva",
            }
        ];

        /*
         var markersData = [
         {
         lat: -23.5516808,
         lng: -46.5212679,
         nome: "Cofema",
         morada1:"Av Arivanduva",
         morada2:"Sumaré",
         codPostal: "3830-772 Gafanha da Nazaré"
         }
         ];
         */
        // Esta função vai percorrer a informação contida na variável markersData
        // e cria os marcadores através da função createMarker

        function displayMarkers(){

            // esta variável vai definir a área de mapa a abranger e o nível do zoom
            // de acordo com as posições dos marcadores
            var bounds = new google.maps.LatLngBounds();

            // Loop que vai percorrer a informação contida em markersData
            // para que a função createMarker possa criar os marcadores
            for (var i = 0; i < markersData.length; i++){

                var latlng = new google.maps.LatLng(markersData[i].lat, markersData[i].lng);
                var nome = markersData[i].nome;
                var end = markersData[i].end;
                var status = markersData[i].status;
                var cep = markersData[i].cep;

                createMarker(latlng, nome, end, status, cep);

                // Os valores de latitude e longitude do marcador são adicionados à
                // variável bounds
                bounds.extend(latlng);
            }

            // Depois de criados todos os marcadores,
            // a API, através da sua função fitBounds, vai redefinir o nível do zoom
            // e consequentemente a área do mapa abrangida de acordo com
            // as posições dos marcadores
            map.fitBounds(bounds);
        }

        // Função que cria os marcadores e define o conteúdo de cada Info Window.
        function createMarker(latlng, nome, end, status, cep){
            if(nome == 'Cofema') {
                var marker = new google.maps.Marker({
                    map: map,
                    position: latlng,
                    title: nome,
                    icon: 'http://maps.google.com/mapfiles/marker_purpleC.png'
                });
            }else if(status == 'F'){
                var marker = new google.maps.Marker({
                    map: map,
                    position: latlng,
                    title: nome,
                    icon: 'http://maps.google.com/mapfiles/marker_greenF.png'
                });
            }else if(status == 'O'){
                var marker = new google.maps.Marker({
                    map: map,
                    position: latlng,
                    title: nome,
                    icon: 'http://maps.google.com/mapfiles/marker_yellowO.png'
                });
            }else if(status == 'P') {
                var marker = new google.maps.Marker({
                    map: map,
                    position: latlng,
                    title: nome,
                    icon: 'http://maps.google.com/mapfiles/markerP.png'
                });
            }else if(status == 'N'){
                var marker = new google.maps.Marker({
                    map: map,
                    position: latlng,
                    title: nome,
                    icon: 'http://maps.google.com/mapfiles/marker_purpleN.png'
                });
            }else{
                var marker = new google.maps.Marker({
                    map: map,
                    position: latlng,
                    title: nome,
                    icon: 'http://labs.google.com/ridefinder/images/mm_20_white.png'
                });
            }


            // Evento que dá instrução à API para estar alerta ao click no marcador.
            // Define o conteúdo e abre a Info Window.
            google.maps.event.addListener(marker, 'click', function() {

                // Variável que define a estrutura do HTML a inserir na Info Window.
                var iwContent = '<div id="iw_container">' +
                        '<div class="iw_title">' + nome + '</div>' +
                        'Status: ' + status + '<br />' +
                        '<div class="iw_content">' + end + '<br />' +
                        'Cep: ' + cep + '</div></div>';

                // O conteúdo da variável iwContent é inserido na Info Window.
                infoWindow.setContent(iwContent);

                // A Info Window é aberta com um click no marcador.
                infoWindow.open(map, marker);
            });
        }

        function initialize() {
            var mapOptions = {
                center: new google.maps.LatLng(-23.558566,-46.5137027),
                zoom: 12,
                mapTypeId: 'roadmap',
            };

            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            // Cria a nova Info Window com referência à variável infoWindow.
            // O conteúdo da Info Window é criado na função createMarker.
            infoWindow = new google.maps.InfoWindow();

            // Evento que fecha a infoWindow com click no mapa.
            google.maps.event.addListener(map, 'click', function() {
                infoWindow.close();
            });

            // Chamada para a função que vai percorrer a informação
            // contida na variável markersData e criar os marcadores a mostrar no mapa
            displayMarkers();
        }
        google.maps.event.addDomListener(window, 'load', initialize);


    </script>



@endsection