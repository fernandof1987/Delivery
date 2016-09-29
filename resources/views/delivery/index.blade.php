@extends('layouts.app')

@section('content')
     <style>
        #map-canvas {
            width: 100%;
            height: 600px;
        }
    </style>

     <h4><strong>Cofema Delivey</strong></h4>

     <section class="well">
         Clientes: <strong>{{ count($clientes) }}</strong>
         <form>
             Cliente:
             <input type="number" name="cli_cod"/>
             Cidade:
             <select name="cidades">
                 <option></option>
                 @foreach($cidades as $cidade)
                     <option name="cle_cidade">{{ $cidade->cle_cidade }}</option>
                 @endforeach
             </select>
             Status:
             <select name="status">
                 <option></option>
                 <option name="cle_status">F</option>
                 <option name="cle_status">O</option>
                 <option name="cle_status">P</option>
                 <option name="cle_status">I</option>
                 <option name="cle_status">N</option>
             </select>
             <input type="submit" value="ok">
         </form>
     </section>




    <div id="map-canvas"></div>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script>
        //Blade + PHP popula variavel makerData com dados vidos do banco
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
            //Dados Cofema SP e Sumar�
            {
                lat: -23.5516808,
                lng: -46.5212679,
                nome: "Cofema",
                end:"Av Arivanduva",
            },
            {
                lat: -22.8333219,
                lng: -47.1770954,
                nome: "Cofema",
                end:"Sumar�",
            }
        ];


        // Esta fun��o vai percorrer a informa��o contida na vari�vel markersData
        // e cria os marcadores atrav�s da fun��o createMarker
        function displayMarkers(){

            // esta vari�vel vai definir a �rea de mapa a abranger e o n�vel do zoom
            // de acordo com as posi��es dos marcadores
            var bounds = new google.maps.LatLngBounds();

            // Loop que vai percorrer a informa��o contida em markersData
            // para que a fun��o createMarker possa criar os marcadores
            for (var i = 0; i < markersData.length; i++){

                var latlng = new google.maps.LatLng(markersData[i].lat, markersData[i].lng);
                var nome = markersData[i].nome;
                var end = markersData[i].end;
                var status = markersData[i].status;
                var cep = markersData[i].cep;

                createMarker(latlng, nome, end, status, cep);

                // Os valores de latitude e longitude do marcador s�o adicionados �
                // vari�vel bounds
                bounds.extend(latlng);
            }

            // Depois de criados todos os marcadores,
            // a API, atrav�s da sua fun��o fitBounds, vai redefinir o n�vel do zoom
            // e consequentemente a �rea do mapa abrangida de acordo com
            // as posi��es dos marcadores
            map.fitBounds(bounds);
        }

        // Fun��o que cria os marcadores e define o conte�do de cada Info Window.
        function createMarker(latlng, nome, end, status, cep){

            //icones maps
            c = 'http://maps.google.com/mapfiles/marker_purpleC.png';
            f = 'http://maps.google.com/mapfiles/marker_greenF.png';
            o = 'http://maps.google.com/mapfiles/marker_yellowO.png';
            p = 'http://maps.google.com/mapfiles/markerP.png';
            n = 'http://maps.google.com/mapfiles/marker_purpleN.png';
            i = 'http://labs.google.com/ridefinder/images/mm_20_white.png';

            var icone;
            if(nome == 'Cofema')
                icone = c;
            else if(status == 'F')
                icone = f;
            else if(status == 'O')
                icone = o;
            else if(status == 'P')
                icone = p;
            else if(status == 'N')
                icone = n;
            else
                icone = i;

            var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                title: nome,
                icon: icone
            });

            // Evento que d� instru��o � API para estar alerta ao click no marcador.
            // Define o conte�do e abre a Info Window.
            google.maps.event.addListener(marker, 'click', function() {

                // Vari�vel que define a estrutura do HTML a inserir na Info Window.
                var iwContent = '<div id="iw_container">' +
                        '<div class="iw_title">' + nome + '</div>' +
                        'Status: ' + status + '<br />' +
                        '<div class="iw_content">' + end + '<br />' +
                        'Cep: ' + cep + '</div></div>';

                // O conte�do da vari�vel iwContent � inserido na Info Window.
                infoWindow.setContent(iwContent);

                // A Info Window � aberta com um click no marcador.
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

            // Cria a nova Info Window com refer�ncia � vari�vel infoWindow.
            // O conte�do da Info Window � criado na fun��o createMarker.
            infoWindow = new google.maps.InfoWindow();

            // Evento que fecha a infoWindow com click no mapa.
            google.maps.event.addListener(map, 'click', function() {
                infoWindow.close();
            });

            // Chamada para a fun��o que vai percorrer a informa��o
            // contida na vari�vel markersData e criar os marcadores a mostrar no mapa
            displayMarkers();
        }
        google.maps.event.addDomListener(window, 'load', initialize);


    </script>



@endsection