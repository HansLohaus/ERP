/**
 * Extension de iconos para gmaps.js
 */

// Para saber si es IE o no
var isIE;
if (typeof(isIE) == "undefined") {
    isIE = /*@cc_on!@*/false || !!document.documentMode;
}

// utilidad para cambiar la luminocidad de un color
function shadeColor(color, percent) {   
    var f=parseInt(color.slice(1),16),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=f>>16,G=f>>8&0x00FF,B=f&0x0000FF;
    return "#"+(0x1000000+(Math.round((t-R)*p)+R)*0x10000+(Math.round((t-G)*p)+G)*0x100+(Math.round((t-B)*p)+B)).toString(16).slice(1);
}

// Directorio en donde se encuentran los iconos
GMaps.prototype.svgBase = "assets/plugins/gmaps-svg-icons/icons";

// Para codificar los iconos
GMaps.prototype.svgEncode = function( data ) {
    if ( data.indexOf( '"' ) >= 0 ) {
        data = data.replace( /"/g, "'" );
    }
    data = data.replace( />\s{1,}</g, "><" );
    data = data.replace( /\s{2,}/g, " " );
    return data.replace( /[\r\n"%#()<>?\[\\\]^`|]/g , escape );
};

// Obtener un icono
GMaps.prototype.svgMakeIcon = function( data ) {

    // Si solo se ingresa un string, se obtiene el icono directamente
    if (typeof(data) == "string") {
        var type = data;
        data = {
            type : type
        };
    }

    // Algunos parametros por defecto
    // Si solo se define size
    if (data.hasOwnProperty("size")) {
        data.width = data.size;
        data.height = data.size;
    }

    // Se obtiene el origen del icono
    if (!data.hasOwnProperty("originx")) {
        data.originx = 0;
    }
    if (!data.hasOwnProperty("originy")) {
        data.originy = 0;
    }

    // Se obtiene el centro del icono
    if (!data.hasOwnProperty("anchorx")) {
        data.anchorx = data.width/2.0;
    }
    if (!data.hasOwnProperty("anchory")) {
        data.anchory = data.height/2.0;
    }

    // El objeto de entrada debe tener al menos un tipo
    if (data.hasOwnProperty("type")) {

        // La base debe estar definida
        if (this.svgBase !== null) 
        {
            var me = this;

            // para obtener el icono
            var iconResult;

            // Se obtiene el archivo svg
            $.ajax({
                url: this.svgBase+"/"+data.type+".svg",
                async: false,
                method: "GET",
                dataType: "text"
            }).done(function(template){

                // Se modifican los parametros
                var rendered = Mustache.render(template,data);

                // Se codifica
                var result = "data:image/svg+xml,"+me.svgEncode(rendered);

                // Si no es IE
                if (!isIE) {

                    // Se obtiene el icono
                    iconResult = {
                        size: new google.maps.Size(data.width, data.height),
                        origin: new google.maps.Point(data.originx, data.originy),
                        anchor: new google.maps.Point(data.anchorx, data.anchory),
                        url: result
                    };

                } else {

                    // Se obtiene el icono
                    iconResult = {
                        scaledSize: new google.maps.Size(data.width, data.height),
                        origin: new google.maps.Point(data.originx, data.originy),
                        anchor: new google.maps.Point(data.anchorx, data.anchory),
                        url: result
                    };
                }
            });

            return iconResult;
        }
    } else {
        return null;
    }  
};

// Para agregar un marcador
GMaps.prototype.svgAddMarker = function( options ){

    // Las opciones deben tener al menos el icono
    if (options.hasOwnProperty("icon")) {

        // Se obtiene el codigo de icono
        var icon = options.icon;

        // Se reemplaza por un icono svg
        options.icon = this.svgIcon(icon);

        // Para guardar la latitud y longitud
        var lat, lng, marker;
        if (!isIE) {

            // Se obtiene el marcador
            if (options.hasOwnProperty("lat") && options.hasOwnProperty("lng"))
            {
                lat = parseFloat(options.lat);
                lng = parseFloat(options.lng);
                if (lat !== 0.0 && lng !== 0.0) {
                    marker = this.addMarker(options);
                }
            }

        } else {

            // Se obtiene el marcador
            if (options.hasOwnProperty("lat") && options.hasOwnProperty("lng"))
            {
                lat = parseFloat(options.lat);
                lng = parseFloat(options.lng);
                if (lat !== 0.0 && lng !== 0.0) {
                    options.optimized = false;
                    marker = this.addMarker(options);
                }
            }
        }
        return marker;
    }  
};

// Para generar un icono
GMaps.prototype.svgIcon = function( data ) {

    // Si solo se ingresa un string, se obtiene el icono directamente
    if (typeof(data) == "string") {
        var type = data;
        data = {
            type : type
        };
    }

    // debe estar definidos los siguientes campos
    if (data.hasOwnProperty("type")) {

        var color = "#FF0000";
        if (data.hasOwnProperty("color")) {
            color = data.color;
        }

        var size = 42;
        if (data.hasOwnProperty("size")) {
            size = data.size;
        }

        switch (data.type) {
            case "camion" :
            case "camioneta" :
            case "emergencia" :
            case "marcador" :

                var width = (parseFloat(size)/1.416396666666667);
                var height = size;

                return this.svgMakeIcon({
                    "type" : data.type,
                    "colorLight" : shadeColor(color,0.5),
                    "colorDark" : shadeColor(color,-0.5),
                    "colorStroke" : shadeColor(color,-0.2),
                    "colorIcon" : "#ffffff",
                    "color"  : color,
                    "width"  : width,
                    "height" : height,
                    "anchory" : height
                });

            break;
            case "posicion" :

                return this.svgMakeIcon({
                    "type" : data.type,
                    "size" : size,
                    "colorLight" : shadeColor(color,0.5),
                    "colorDark" : shadeColor(color,-0.5),
                    "colorStroke" : shadeColor(color,-0.6)
                });

            break;
        }
    }
};