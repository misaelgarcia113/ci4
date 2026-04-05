$(document).ready(function()
{
	getIp().then(ip => 
    { 
        sendIp(ip);
    });
      
    function getIp()
    {
        return fetch('https://api.ipify.org?format=json').then(response => response.json()).then(data => 
        { 
            return data.ip;
        });
    }

    function sendIp(ip)
    {
        var url = "http://localhost/ci4/services/geolocation";
        
        $.ajax({
            type: 'POST',
            url: url,
            data: {'infoIp': ip},
        
            success: function (response) 
            {

                var ip = response.ip; 
                $('#ip-display').text(ip);
                $('#city-display').text(response.city);
                $('#country-display').text(response.country);
                $('#carrier-display').text(response.carrier);

                $('#resultado-container').fadeIn();
                //alert("Tu ip es: " + response.ip);
                //alert("La ciudada es: " + response.city);
                //alert("El pais es: " + response.country);
                //alert("El proveedor es: " + response.carrier);
            },
            error: function () 
            {
                console.error("Error al procesar la peticion.");
            }
        });
    }
});