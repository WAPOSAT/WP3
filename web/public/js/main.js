var Risk="";
var Danger="";
var Icono=""; 
var estilo=""; 
var actualizarProceso=null;
var actualizarEstacion=null;
var actualizarParametro=null;
var pathIMG="public/img/"; 
var nodo=null;
var pushLeft=null; 
var pushRight=null;
var lastId = 0;

  
$(document).ready(function(){
  // la variable [vista] tiene valores 1 o 2 dependiendo de cual es la vista de la plataforma que se desea
  // esta es ingresada por el controlador desde el codigo twig    
  LoadNav(vista);
  $("footer").html('Copyright &copy; Waposat 2016');
});


/*
* LoadNav
* Construye el menu de navegacion y la barra de herramientas del sistema
*/
function LoadNav(type = 1){
  var ruta=null;
  var funcion=null;
  var change;
  // Dependiendo del tipo de vista deseado, se define una ruta y la funcion de carga de informacion
  if (type==1) {ruta="/dashboard";
    funcion="ShowBlock";
    change = "<div class='Change' title='Cambiar a vista SCADA' onclick='LoadScada()'><i class='fa fa-map' aria-hidden='true'></i></div>";
  }
  if (type==2) {ruta="v2/dashboard";
    funcion="ShowPlain";
    change = "<div class='Change' title='Cambiar a vista ALERTAS' onclick='LoadAlert()'><i class='fa fa-th-large' aria-hidden='true'></i></div>";
  }

  // Se utiliza la [ruta] obtenida para iniciar la carga de informacion
  //Se realiza una consulta AJAX con el metodo POST utilizando JQUERY
  $.post(ruta, function(response) {

    var data=jQuery.parseJSON(response);
    // Se genera el menu izquierdo
    nodo=document.getElementsByTagName("aside")[0];
    pushLeft = new Menu({type: 'push-left', menuOpenerClass: '.menuleft',Menu:nodo});
    // Se genera el menu derecho
    nodo1=document.getElementsByTagName("aside")[1];
    pushRight = new Menu({type: 'push-right', menuOpenerClass: '.menuright',Menu:nodo1});

    var items = [];
    // Establece el color del fondo
    $("section").css("background-color","#ffffff");
    // Carga del menu principal


    $("header").html('<div><a class="icon" onclick="pushLeft.open()"><i class="fa fa-bars" aria-hidden="true"></i></a>\n\
                      <div  class="logo"><img src="public/img/waposat-imagotipo-rightside.png" class="LogoToolBar labelExport">\n\
                      <img src="public/img/waposat-isotipo.png" class=" LogoToolBar labelphone"></div>\n\
                      <div id="HiUser" class=user><label class=labelExport>'+data.HiUser+'</label></div><div id=infoscada></div>\n\
                      <a class="icon-close" id=Close><i class="fa fa-power-off" aria-hidden="true"></i></a>\n\
                      <div class="BoxAlert"><i class="fa fa-bell" aria-hidden="true" style="float:left"></i> <label class=labelExport><span class="InfoDanger InfoLittle ">'+data.NumDanger+'</span><span class="InfoRisk InfoLittle ">'+ data.NumRisk+'</span></label></div>\n\
                      <div class="Export" onclick="Export()"><i class="fa fa-share-square-o" aria-hidden="true"></i> <label class=labelExport>Exportar</label></div>\n\
                      '+change+'</div>');

    /* Para agregar el boton de EXPORTAR
    <div class="Export" onclick="Export()"><i class="fa fa-share-square-o" aria-hidden="true"></i> <label class=labelExport>Exportar</label></div>\n\
    */
    
    // Carga del menu izquierdo [BLOQUES]  
    items.push('<div id="bloques" onclick=pushLeft.close()>BLOQUES <i class="fa fa-arrow-right" aria-hidden="true"></i></div>');
    var num=0;
    // Se trabaja con cada ProcessBlock
    $.each(data.ProcessBlock, function(key, val) {
      if(num==0){
        if(type==1) {
          ShowBlock(val.id);
        }
        if(type==2){
          ShowPlain(val.id);
        }
      }
      num+=1;

      items.push('<a onclick='+funcion+'('+val.id+')>' + val.Name +'<br />' + val.CodeName +'</a>');
    });
         
    $('<nav/>', {'class': 'menu', html: items.join('')}).appendTo(nodo);

    ShowAlert(type);

    // Boton de cerrado de session
    $('#Close').click(function(){
      CloseSession();
    });
  });
} // End LoadNav


/*
*   CONTROLES PARA PLATAFORMA DE ALERTAS
* Las siguientes funciones se encargan de utilizar los archivos JSON recibidos desde el Back-end
* utilizando esta informacion para desplegar todas las vistas, menu derecho, menu izquierdo y panel principal
* cada funcion tiene una breve explicacion de la tarea especifica que debe realizar
*/


/*
* ShowBlock
* Construye los cuadro de Station Block en base a la data
*/
function ShowBlock(id,risk=1,danger=1,stable=1){
  
  $("section").html('<div class=Block><div class=filtros>\n\
  <form id="formulario" name=formulario>\n\
  <label class="labelExport" >Estaciones de Monitoreo (<span id="puntos">0</span>)</label> \n\
  <label><input type="checkbox" name="critico" '+(risk==1?'checked':'')+' onclick="ShowBlock('+id+',(document.formulario.critico.checked?1:0),(document.formulario.alerta.checked?1:0),(document.formulario.estable.checked?1:0))" value=1> Critico</label>\n\
  <label><input type="checkbox" name="alerta" '+(danger==1?'checked':'')+' onclick="ShowBlock('+id+',(document.formulario.critico.checked?1:0),(document.formulario.alerta.checked?1:0),(document.formulario.estable.checked?1:0))"  value=1> Alerta</label>\n\
  <label><input type="checkbox" name="estable" '+(stable==1?'checked':'')+' onclick="ShowBlock('+id+',(document.formulario.critico.checked?1:0),(document.formulario.alerta.checked?1:0),(document.formulario.estable.checked?1:0))"  value=1> Estable</label></form>\n\
  </div>\n\
  <div id=main class="boxcols"></div></div><div class=DetailBlock></div>');
  $.getJSON('dashboard/process/'+id+'/states/'+risk+'/'+danger+'/'+stable, function(data) {
  
    // Desactiva la actualizacion de datos por AJAX
    clearInterval(actualizarProceso);

    // Se establece la recarga de datos dinamicos con AJAX
    actualizarProceso=setInterval('UpdateProcess('+id+')', (data.RefreshFrecuencySeg*1000));

    // Se muestra el numero de bloques estacion
    $("#puntos").html(data.StationBlock.length);

    // Se almacenara en la variable [cadena] cada cuadro de Bloque Estacion
    var cadena="";
    var num=0;

    $.each(data.StationBlock, function(key, val) {
        
      Risk='';
      Danger='';
      Icono=''; 
      estilo='';
      
      if(num==0){
        ShowPoint(val.id);
      }
      num++;

      // Genera todo el contenido del cuadro de una Station Block
      if(val.NumRisk>0){
        Risk='<div  class=InfoRisk id=RiskStation'+val.id+'>' + val.NumRisk +'</div>';}
      if(val.NumDanger>0){
        Danger='<div  class=InfoDanger id=DangerStation'+val.id+'>' + val.NumDanger +'</div>';}
      
      if(val.NumDanger==0 && val.NumRisk==0 ){
        Icono=''; 
        estilo='PanelHeadStable';}
      else if(val.NumDanger==0 && val.NumRisk>0){
        Icono='<i class="fa fa-exclamation-circle" aria-hidden="true"></i>';
        estilo='PanelHeadRisk';}
      else{
        Icono='<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
        estilo='PanelHeadDanger';}
         
      cadena+='<div class="box" onclick="ShowPoint('+ val.id +')" ><div class="Panel"><div id="PanelBoxColor'+val.id+'" class='+estilo+'><table class=TablaPanel><tr><td id="PanelAlerta'+val.id+'" class=PanelAlerta>'+Icono+'</td><td class=PanelTitulo >'+ val.Name +'<br>' + val.CodeName +'</td><td align=right width="30%">'+ Danger + Risk +'</td></tr></table></div><div id="PanelBody'+val.id+'" class=PanelBody>';
      
      var cont=0;
      $.each(data.StationBlock[key].Sensor, function(k, v) {
        if (cont<4){
          cadena+='<div class=PanelDetalle><span>' + v.CodeName +': </span><span id=sensor'+v.id+'> ' + v.Last.Value +' '+v.Unit+'</span></div>';
          cont++;
        }
      });
       
      cadena+='</div></div></div>';
      $("#main").html(cadena); 
      
      calBoxCol();
      ResizeCol();
      pushLeft.close();
    });
  });

} // End ShowBlock


/*
* UpdateProcess
* Actualiza la informacion dinamica de los ProcessBlock
*/
function UpdateProcess(id){
  // Realiza una peticion utilizando AJAX para la actualizacion del ProcessBlock
  $.getJSON('dashboard/update/process/'+id, function(data) {
    var cadena;
    // Realiza la actualizacion de cada Station Block recibida
    $.each(data.StationBlock, function(key, val) {
      cadena = "";
      $("#RiskStation"+val.id).html(val.NumRisk);
      $("#DangerStation"+val.id).html(val.NumDanger);

      if(val.NumDanger==0 && val.NumRisk==0 ){
        Icono=''; 
        estilo='PanelHeadStable';}
      else if(val.NumDanger==0 && val.NumRisk>0){
        Icono='<i class="fa fa-exclamation-circle" aria-hidden="true"></i>';
        estilo='PanelHeadRisk';}
      else{
        Icono='<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
        estilo='PanelHeadDanger';}

      // Actualizando el color de la cabecera del StationBlock
      $("#PanelBoxColor"+val.id).removeClass();
      $("#PanelBoxColor"+val.id).addClass(estilo);
      // Actualizando el icono de la cabecera del StationBlock
      $("#IconPanelAlerta").html(Icono);
        
      // Realiza la actualizacion de cada Sensor recibido por Station Block
      var cont=0;
      $.each(data.StationBlock[key].Sensor, function(k, v) {
        if (cont<4){
          cadena+='<div class=PanelDetalle><span>' + v.CodeName +': </span><span id=sensor'+v.id+'> ' + v.Last.Value +' '+v.Unit+'</span></div>';
          cont++;
        }
      });

      $("#PanelBody"+val.id).html(cadena);

    });
  });    
} // End of UpdateProcess


/*
* ShowPoint
* Contruye el cuadro de una Station Block
*/
function ShowPoint(id){

  $.getJSON('dashboard/station/'+id,function(data){
    
    // Desactiva la actualizacion de datos por AJAX
    clearInterval(actualizarEstacion);
    actualizarEstacion=setInterval('UpdateStation('+id+')',5000);

    if(data.NumDanger==0 && data.NumRisk==0 ){
      Icono=''; 
      estilo='PanelHeadStable';}
    else if(data.NumDanger==0 && data.NumRisk>0){
      Icono='<i class="fa fa-exclamation-circle" aria-hidden="true"></i>';
      estilo='PanelHeadRisk';}
    else{
      Icono='<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
      estilo='PanelHeadDanger';
    }
    
    $(".DetailBlock").html("<table class=TablaPoint>\n\
    <tr><td><div id='HeadTableStation' class='"+estilo+"' ><table class='HeadTableStation' width=100%><tr><td width=20><div id=IconPanelAlerta Class=PanelAlerta style='color:#FFFFFF;font-size:22px'>"+ Icono +"</div></td><td style='color:#FFFFFF'> "+data.Name+"<br>"+data.CodeName+"</td><td align=right><div class='MenuRight' onclick='BlockDetail("+data.id +");pushRight.open()'><i class='fa fa-bars' aria-hidden='true'></i></div></td></tr></table></div></td></tr>\n\
    <tr><td> <div id=ChartGauge class=Group></div></div></td></tr>\n\
    <tr><td align=center id=SensorInfo >\n\
    <table>\n\
    <tr><td colspan=2><div id=ChartTittle style='text-align:center'></div></td></tr>\n\
    <tr><td colspan=2><div id='LastValue' style='text-align:center'></div></td></tr>\n\
    <tr><td colspan=2><div id=ChartLines></div></td></tr>\n\
    <tr><td><div id='ChartDetail'  class='DetailChart Black'></div> </td> <td valign=top><div id=filtro></div> </td></tr></table></td></tr></table>");
    
    ResizeCol();
    calBoxCol();
    // Generando Cuadro de Gauge
    GaugeGenerate(data.Sensor,id,1);
  });
} // End of ShowPoint


/*
* UpdateStation
* Actualiza la informacion dinamica del StationBlock
*/
function UpdateStation(id){
  // Realiza una peticion utilizando AJAX para la actualizacion del StationBlock
  $.getJSON('dashboard/station/'+id, function(data) {
    
    if(data.NumDanger==0 && data.NumRisk==0 ){
      Icono=''; 
      estilo='PanelHeadStable';}
    else if(data.NumDanger==0 && data.NumRisk>0){
      Icono='<i class="fa fa-exclamation-circle" aria-hidden="true"></i>';
      estilo='PanelHeadRisk';}
    else{
      Icono='<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
      estilo='PanelHeadDanger';
    }

    // Actualizando el color de la cabecera del StationBlock
    $("#HeadTableStation").removeClass();
    $("#HeadTableStation").addClass(estilo);
    // Actualizando el icono de la cabecera del StationBlock
    $("#IconPanelAlerta").html(Icono);
    
    // Generando Cuadro de Gauge
    GaugeGenerate(data.Sensor,id,0);
    UpdateSensorsTable(data.Sensor, id);

  });
} // End of UpdateStation


/*
* BlockDetail 
* Carga la informacion de todos los sensores en el menu derecho de la plataforma
*/
function BlockDetail(idstation=1){

  $.getJSON('dashboard/station/'+idstation, function(data) {
    var items = [];

    items.push('<div class="DetailHead" onclick=pushRight.close()><i class="fa fa-arrow-right" aria-hidden="true"></i> Parametros Totales</div>\n\
                <div class=Detail><span>'+data.Name+'<br>'+data.CodeName+'</span>\n\
                <div style="padding-left:20px;" id="SensorsTable" ><table class="tablainformativa">');
    items.push('<tr><th>Parámetro</th><th>Min</th><th>Max</th><th>Actual</th></tr>');
    var stylo='';

    $.each(data.Sensor, function(key, val) {
      stylo=' class="Stable"';
      if(val.Last.Value>=val.LMR && val.Last.Value<=val.LMP){
        stylo=' class="Risk"';
      }else if(val.Last.Value>val.LMP){
        stylo=' class="Danger"';
      }  

      items.push('<tr class="TableSensors" onclick="ChangeParameter('+idstation +','+val.id +', 20, 5)" ><td>' + val.Name +'</td><td>' + val.MinValue +'</td><td>' + val.MaxValue +'</td><td '+ stylo +'><span '+stylo+'>' + val.Last.Value +'</span></td></tr>');
    });

    items.push('</table></div> <a href=javascript:pushRight.close() class=ButtonBack>Volver</a></div>');
    $(nodo1).html(items.join(''));
  });
 
} //  End of BlockDetail


/*
* UpdateSensorsTable
* Genera la tabla de valores de los sensores en el menu derecho
*/
function UpdateSensorsTable(Sensor, idstation=1){
  var cadena="";
  cadena += "<table class='tablainformativa'>";
  cadena += "<tr><th>Parámetro</th><th>Min</th><th>Max</th><th>Actual</th></tr>";
  $.each(Sensor , function(key, val) {
    stylo=' class="Stable"';
    if(val.Last.Value>=val.LMR && val.Last.Value<=val.LMP){
      stylo=' class="Risk"';
    }else if(val.Last.Value>val.LMP){
      stylo=' class="Danger"';
    }
    cadena += '<tr class="TableSensors" onclick="ChangeParameter('+idstation +','+val.id +', 20, 5)" ><td>' + val.Name +'</td><td>' + val.MinValue +'</td><td>' + val.MaxValue +'</td><td '+ stylo +'><span '+stylo+'>' + val.Last.Value +'</span></td></tr>';
  });
  cadena += "</table>";

  $("#SensorsTable").html(cadena);
} //  End of UpdateSensorsTable


/*
* ChangeParameter
* Se ejecuta al hacer clic a un parametro en la tabla del menu derecho
*/
function ChangeParameter(idstation=1,idsensor=1,long=20, Refresh=5 ){
  showparameter(idstation,idsensor,long,Refresh);
  pushRight.close();
} //  End of ChangeParameter


/*
* showparameter
* Carga la informacion del sensor
*/
function showparameter(idstation=1,idsensor=1,long=20, Refresh=5 ){

  $.getJSON('dashboard/station/'+idstation+'/sensor/'+idsensor+'/long/'+long,function(data){
    
    lastId= data.Last.id;
    console.log(data.Last.id);

    // Detiene alguna ejecucion previa de carga de datos dinamicos del BlockStation e inicia una nueva
    clearInterval(actualizarParametro);
    actualizarParametro=setInterval('showParameterUpdate('+idstation+','+idsensor+','+data.LMP+','+data.LMR+')', (Refresh*1000));

    $("#ChartTittle").html("<h6>"+data.Name+"</h6><span class=subtitulo>"+data.Unit+" vs Tiempo</span>");
    $("#ChartDetail").html('<table><tr><td>Maximo:</td><td><label id="MaxValueSensors" >'+data.MaxValue.toFixed(2)+ '</label></td></tr><tr><td>Medio:</td><td><label id="MeanValueSensors">'+data.MeanValue.toFixed(2) +'</label></td></tr><tr><td>Minimo:</td><td><label id="MinValueSensors" >'+data.MinValue.toFixed(2) +'</label></td></tr></table><div></div>');
    $("#filtro").html('<select onchange=showparameter('+idstation+','+idsensor+',this.value,'+Refresh+') id=ListPoint><option value=10 '+ (long==10?'selected':'') + '> 10 Puntos</option><option value=20 '+ (long==20?'selected':'') +'> 20 Puntos</option></select><div id=limites><label>Limite: '+data.LMR+' - '+data.LMP+'</label> <i class="fa fa-cog" aria-hidden="true"></i></div>');
    $("#LastValue").html("<h5>Medida Actual: "+data.Last.Value+" "+data.Unit+"</h5><span class=subtitulo>"+data.Last.Date+"</span>");
    
    var datos="[";
    for(a=0;a<=data.Data.Time.length-1;a++){
      var d = new Date("1 1, 2016 "+data.Data.Time[a]);

      datos+="[["+ d.getHours() +","+ d.getMinutes() +","+d.getSeconds()+"],"+ data.Data.Value[a]+","+data.LMR+","+data.LMP+"],";
    }
    datos=datos.substr(0,datos.length-1)+"]";

    drawCurveTypes('ChartLines',380,200,datos,data.Name);  
  });  
}


/*
* showParameterUpdate
* Actualizacion de la informacion dinamica del Sensor
*/
function showParameterUpdate(idstation=1,idsensor=1,LMP=100,LMR=50){
  ///dashboard/update/station/{idStation}/sensor/{idSensor}/lastid/{lastId}
  $.getJSON('dashboard/update/station/'+idstation+'/sensor/'+idsensor+'/lastid/'+lastId,function(data){
    if(data.Data.Time.length > 0){
      // se guarda como variable global lastId
      lastId=data.Last.id;
      $("#LastValue").html("<h5>Medida Actual: "+data.Last.Value+" "+data.Unit+"</h5><span class=subtitulo>"+data.Last.Date+"</span>");
      console.log('la ultima medicion'+data.Last.Value);
      var datos="[";
      for(a=0;a<=data.Data.Time.length-1;a++){
        var d = new Date("1 1, 2016 "+data.Data.Time[a]);
        datos+="[["+ d.getHours() +","+ d.getMinutes() +","+d.getSeconds()+"],"+ data.Data.Value[a]+","+LMR+","+LMP+"],";
      }
      datos=datos.substr(0,datos.length-1)+"]";

      UpdateCurveTypes(datos);
    }
  });
}


/*
* GaugeGenerate
* Genera el cuadro de acelerometros [Gauge]
*/
function GaugeGenerate(Sensor,id,generate){ 
  // id -> Id of StationBlock
  // generate -> variable booleana que indica si se debe cargar la grafica del primer sensor (1-carga ; 0-no carga)
  var n;   
  var num=0;
  $("#ChartGauge").html("");
  $.each(Sensor,function(k,v){
    if(num==0 && generate==1){
      showparameter(id,v.id,20,5);  
    }
    if (num<boxCaugeCols){
      // Genera el Gauge para cada Sensor del Station Block 
      $("#ChartGauge").append('<div style="cursor:pointer" class="ItemBox" onclick="showparameter('+id +','+v.id +', 20, 5)" ><div id="chart'+k+'" class="grafico" ></div></div>');
      //n=((v.Last.Value*100)/v.MP);
      
      // Funcion para generar el Gauge
      //drawChart('chart'+k,v.CodeName,Math.round(n * 100) / 100,v.LMP*100/v.MP,100,v.LMR*100/v.MP,v.LMP*100/v.MP);
      //drawChart(id,l,v,dangerini,dangerfin,riskini,riskfin)
      drawChart('chart'+k,v.CodeName,v.Last.Value,v.LMP,v.MP,v.LMR,v.LMP);
      $('#chart'+k).append("<label  style='cursor:pointer' >"+v.Name+"</label>");
    }
    num+=1;
  });
  ResizeCol();
  calBoxCol();
} // End GaugeGenerate

function LoadScada(){
  clearInterval(actualizarProceso);
  clearInterval(actualizarEstacion);
  clearInterval(actualizarParametro);
  $("section").html("Cargando vista SCADA ...");
  $(nodo).html("");
  LoadNav(2);
}


/*
*   CONTROLES PARA PLATAFORMA DE SCADA
* Las siguientes funciones se encargan de utilizar los archivos JSON recibidos desde el Back-end
* utilizando esta informacion para desplegar todas las vistas, menu derecho, menu izquierdo y panel principal
* cada funcion tiene una breve explicacion de la tarea especifica que debe realizar
*/


/*
* ShowPlain
* Contruye la vista SACADA de BlockStation
*/
function ShowPlain(id=1){
  var items = [];
  var puntos="";
  var extra="";

  // Establece el color del fondo
  // Colores de los cuadros #c1c1c1 y #b9b9b9
  $("section").css("background-color","#b9b9b9");
  $("#HiUser").html("");

  // Establece el carrucel para poder ver todas las estaciones en caso sean mas a 6
  items.push('<div id="owl-demo" class="owl-carousel owl-theme">');

  // Se realiza la solicitud de informacion con AJAX 
  $.getJSON("v2/dashboard/process/"+id,function(data){
    
    // Detiene alguna ejecucion previa de carga de datos dinamicos del BlockStation e inicia una nueva
    clearInterval(actualizarProceso);
    actualizarProceso=setInterval('UpdatePlain('+id+')', (data.RefreshFrecuencySeg*1000));
    
    //Inicio del contador de sensores Stable/Risk/Danger
    var sensors = { stable:0, risk:0, danger:0};

    // Se empieza a cargar la informacion de cada StationBlock
    $.each(data.StationBlock,function(key,value){
      puntos="<div style='height:120px'><table align=center border=0>";
      // Se carga la informacion de cada sensor del StationBlock
      $.each(value.Sensor,function(k,v){
        if(v.Last.Value<v.LMR){extra=' InfoStable'; sensors.stable++;}
        else if(v.Last.Value>=v.LMR && v.Last.Value<v.LMP){extra=' InfoRisk '; sensors.risk++ }
        else if(v.Last.Value>=v.LMP){extra=' InfoDanger ';sensors.danger++}
        // cada sensor es definido   
        puntos+='<tr onclick=ShowDetail('+value.id+','+v.id+','+value.RefreshFrecuencySeg+')  style="cursor:pointer" ><td><div id="pointSensor'+ v.id +'" class="' + extra + ' InfoLittlePoint"> </div></td><td align=left>'+ v.CodeName+'</td><td align=left>: <span id=sensor'+ v.id +'>'+v.Last.Value+'</span> '+v.Unit+'</td></tr>'; 
      });
      
      puntos+="</table></div>"
      // Se define la imagen de la estacion
      items.push('<div class="item"><div class=PlainBox>'+ value.CodeName +'</div><br>'+ puntos+'<br>'+ value.Name +'<br><div style="background-image:url('+pathIMG+''+value.URL +'); background-position:top center;height:250px"></img src="ScriptFrontEnd/Screen2/'+value.URL +'"></div></div>');
    });
    
    items.push('</div><a class="btn1 prev"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>  <a class="btn1 next"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>');
    // Se agrega el contenido a la plataforma
    $("section").html(items.join(''));   
    
    // Generacion del cuadro de Peligro, alerta y estables
    // se utilizan las clases labelExport y labeltablet para configurar los elementos visibles dependiendo del tamaño de la pantalla
    $("#infoscada").html("<table cellspacing=0 cellpadding=5><tr><td align=right><label class='labeltablet' >ESTACIONES DE<br>MONITOREO ("+data.StationBlock.length+")</label></td><td class=infoscadacelda><label class='labelExport'>Alerta:</label><span class='InfoRisk InfoLittle'>"+sensors.risk+"</span></td><td  class=infoscadacelda><label class='labelExport'>Cr\u00cdtico:</label><span class='InfoDanger InfoLittle'>"+sensors.danger+"</span></td><td class=infoscadacelda style='border-right:solid 1px #ffffff'><label class='labelExport'>Estable:</label><span  class='InfoStable InfoLittle'>"+sensors.stable+"</span></td></tr></table>");

    // Definiendo el numero de elementos en el Carousel
    var numCarousel = 6;
    if (data.StationBlock.length < 6){
      numCarousel = data.StationBlock.length;
    }
    switch (numCarousel){
      case 1: 
        numCarousel = 2;
        break;
      default: 
        numCarousel = numCarousel;
        break;
    }
    
    // Generando la animacion del Carousel
    var owl = $("#owl-demo");
    // [numCarousel] define el numero inicial de items que tendra la pantalla
    owl.owlCarousel({items : numCarousel});
    $(".next").click(function(){
      owl.trigger('owl.next');
    })
    $(".prev").click(function(){
      owl.trigger('owl.prev');
    })          
  });
  pushLeft.close(); 
} // End of ShowPlain


/*
* UpdatePlain
* Actualiza los valores del cuadro StationBlock
*/
function UpdatePlain(id){

  // Esta funcion considera que en un proceso un sensor no puede pertenecer a dos estaciones diferentes, pues el cambio se realiza
  // utilizando la etiqueta "#pointSensor"+v.id y "#sensor"+v.id 

  $.getJSON("v2/dashboard/update/process/"+id,function(data){
    
    
    var sensors = { stable:0, risk:0, danger:0};

    $.each(data.StationBlock,function(key,value){

      $.each(value.Sensor,function(k,v){

        if(v.Last.Value<v.LMR){extra=' InfoStable'; sensors.stable++;}
        else if(v.Last.Value>=v.LMR && v.Last.Value<v.LMP){extra=' InfoRisk '; sensors.risk++ }
        else if(v.Last.Value>=v.LMP){extra=' InfoDanger ';sensors.danger++}

        $("#sensor"+v.id).html(v.Last.Value);
        // Actualizando el color del punto del sensor
        $("#pointSensor"+v.id).removeClass();
        $("#pointSensor"+v.id).addClass(extra);
        $("#pointSensor"+v.id).addClass("InfoLittlePoint");

      });
    });

    // Generacion del cuadro de Peligro, alerta y estables
    // se utilizan las clases labelExport y labeltablet para configurar los elementos visibles dependiendo del tamaño de la pantalla
    //$("#infoscada").html("<table cellspacing=0 cellpadding=5><tr><td align=right>PUNTOS DE<br>MONITOREO ("+data.StationBlock.length+")</td><td class=infoscadacelda>Alerta: <span class='InfoRisk InfoLittle'>"+sensors.risk+"</span></td><td  class=infoscadacelda> Cr\u00cdtico: <span class='InfoDanger InfoLittle'>"+sensors.danger+"</span></td><td class=infoscadacelda style='border-right:solid 1px #ffffff'> Estable:<span  class='InfoStable InfoLittle'>"+sensors.stable+"</span></td></tr></table>");
    $("#infoscada").html("<table cellspacing=0 cellpadding=5><tr><td align=right><label class='labeltablet' >ESTACIONES DE<br>MONITOREO ("+data.StationBlock.length+")</label></td><td class=infoscadacelda><label class='labelExport'>Alerta:</label><span class='InfoRisk InfoLittle'>"+sensors.risk+"</span></td><td  class=infoscadacelda><label class='labelExport'>Cr\u00cdtico:</label><span class='InfoDanger InfoLittle'>"+sensors.danger+"</span></td><td class=infoscadacelda style='border-right:solid 1px #ffffff'><label class='labelExport'>Estable:</label><span  class='InfoStable InfoLittle'>"+sensors.stable+"</span></td></tr></table>");

  });
} // End of UpdatePlain


/*
* ShowDetail
* Carga el cuadro de informacion del sensor
*/
function ShowDetail(idstation,idsensor,Refresh=5,long=20){

  var n;
  //$('.BoxAlert').tooltipster('close');

  $(nodo1).html('<div id="DetailSensor" class="DetailParameter"></div>');

  // Definicion del titulo del menu
  $("#DetailSensor").append('<div class="DetailHead"><i class="fa fa-arrow-right" aria-hidden="true"></i> Detalles del Parametro</div>');

  $.getJSON('v2/dashboard/station/'+idstation+'/sensor/'+idsensor+'/long/'+long, function(data){

      // Estableciendo el estilo y el icono del sensor
      var stylo='Stable';
      var Icono='<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>';
      if(data.Last.Value>=data.LMR && data.Last.Value<=data.LMP){
        stylo='Risk';
        Icono='<i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>';
      }else if(data.Last.Value>data.LMP){
        stylo='Danger';
        Icono='<i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>';
      }

      var cadena = "";

      // Definicion del header, cuadro de estado del sensor
      cadena += '<div id="DetailAlert" class="'+stylo+'" ><table border=0 cellpadding=0 cellspacing=0><tr><td rowspan=3 width=55>';
      cadena += '<div  id="IconPanelAlerta" class="PanelAlerta" style="font-size:30px">'+Icono+'</div></td>';
      cadena += '<td align=center width=180 colspan=2 style="font-size:11px;font-weight:bold;text-transform:uppercase;">'+data.nameStation+'</td></tr>';
      cadena += '<tr><td colspan=2 align=center style="font-size:20px;font-weight:bold;text-transform:uppercase;">'+data.Name+ '</td></tr>';
      cadena += '<tr><td align=center>'+data.codenameStation+'</td><td align=center>'+data.CodeName+'</td></tr>';
      cadena += '</table></div>';

      $("#DetailSensor").append(cadena);
      cadena = '';

      // Detalles de medicion del sensor
      cadena += '<table align=center border=0><tr><td align=center><div id=Chart></div></td><td rowspan=2  align=center>';
      cadena += '<div class="DetailValue"><table>';
      cadena += '<tr><td>Maximo:</td><td><label id="MaxValueSensors" >'+data.MaxValue.toFixed(2)+ '</label></td></tr>';
      cadena += '<tr><td>Medio:</td><td><label id="MeanValueSensors" >'+data.MeanValue.toFixed(2) +'</label></td></tr>';
      cadena += '<tr><td>Minimo:</td><td><label id="MinValueSensors" >'+data.MinValue.toFixed(2) +'</label></td></tr>';
      cadena += '</table></div></td></tr>';
      cadena += '<tr><td><div id="ChartDetail" class="DetailChart"></div></td></tr>';
      //cadena += '<tr><td colspan=2 align=center><label class="DetailLabel">Limites máximos establecidos por la OMS</label></td></tr>';
      cadena += '<tr><td colspan=2><div id="ChartLines"></div></td></tr>';
      cadena += '<tr><td align=right><select name=long onchange=ShowDetail('+idstation+','+idsensor+','+Refresh+',this.value)><option value="20" '+(long==20?'selected':'')+'>20 puntos</option><option value="10" '+(long==10?'selected':'')+'>10 puntos</option></select></td>';
      cadena += '<td><div id="limites" ><label>Limite: '+data.LMR+' - '+data.LMP+'</label><i class="fa fa-cog" aria-hidden="true"></i></div></td></tr></table>';

      $("#DetailSensor").append(cadena);

      drawChart('Chart',data.CodeName, data.Last.Value, data.LMP, data.MP, data.LMR, data.LMP);
      
      lastId= data.Last.id;
      console.log(data.Last.id);
      
      // Detiene alguna ejecucion previa de carga de datos dinamicos del Sensor e inicia una nueva
      clearInterval(actualizarParametro);
      actualizarParametro=setInterval('ShowSensorDetailUpdate('+idstation+','+idsensor+','+data.LMP+','+data.LMR+')', (Refresh*1000));

      $("#ChartDetail").html('Medida Actual:<br><label>'+data.Last.Value+' '+data.Unit+'</label><br>'+data.Last.Date+'');

      var datos="[";
      for(a=0;a<=data.Data.Time.length-1;a++){
        var d = new Date("1 1, 2016 "+data.Data.Time[a]);
        datos+="[["+ d.getHours() +","+ d.getMinutes() +",0],"+ data.Data.Value[a]+","+data.LMR+","+data.LMP+"],";
      }
      datos=datos.substr(0,datos.length-1)+"]";

      drawCurveTypes("ChartLines",275,180,datos,data.Name);
      pushRight.open();
  });
} // End of ShowDetail


/*
* ShowSensorDetailUpdate
* Actualizacion de la informacion dinamica del Sensor
*/
function ShowSensorDetailUpdate (idstation=1,idsensor=1,LMP=100,LMR=50){
  ///dashboard/update/station/{idStation}/sensor/{idSensor}/lastid/{lastId}
  $.getJSON('v2/dashboard/station/'+idstation+'/sensor/'+idsensor+'/lastid/'+lastId,function(data){
    
    if(data.Data.Time.length > 0){
      
      // se guarda como variable global lastId
      lastId=data.Last.id;

      // Estableciendo el estilo y el icono del sensor
      var stylo='Stable';
      var Icono='<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>';
      if(data.Last.Value>=LMR && data.Last.Value<=LMP){
        stylo='Risk';
        Icono='<i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>';
      }else if(data.Last.Value>LMP){
        stylo='Danger';
        Icono='<i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>';
      }

      $("#DetailAlert").removeClass();
      $("#DetailAlert").addClass(stylo);

      $("#ChartDetail").html('Medida Actual:<br><label>'+data.Last.Value+' '+data.Unit+'</label><br>'+data.Last.Date+'');
      $("#IconPanelAlerta").html(Icono);

      var datos="[";
      for(a=0;a<=data.Data.Time.length-1;a++){
        var d = new Date("1 1, 2016 "+data.Data.Time[a]);

        datos+="[["+ d.getHours() +","+ d.getMinutes() +","+d.getSeconds()+"],"+ data.Data.Value[a]+","+LMR+","+LMP+"],";
      }
      datos=datos.substr(0,datos.length-1)+"]";

      UpdateCurveTypes(datos);
    }
  });
} // End of ShowSensorDetailUpdate


/*
* ShowAlert
* Carga la vinieta para la visualizacion de los eventos
*/
function ShowAlert(type=1){
  var ruta=null;
  if (type==1) {ruta="dashboard/alerts/";}
  if (type==2) {ruta="v2/dashboard/alerts/";}

  $.getJSON(ruta,function(data){
    var items=[];
    items.push('<div class=BoxMessage><ul class="Message">');
    $.each(data.Alert,function(k,v){
      extra='';
      if(v.AlertType==0)
      {extra=' InfoRisk ';
      estilomensaje=' class=MessageRisk ';}
      else
      {extra=' InfoDanger ';
      estilomensaje=' class=MessageDanger ';}
      if (type==1)
      {items.push('<li onclick="ShowBlock('+ v.idProcessBlock +')" '+estilomensaje+'><div class="'+extra+' InfoLittlePoint InfoList"> </div> ' +v.Message+'</li>');}
      if (type==2)
      {items.push('<li onclick="ShowPlain('+ v.idProcessBlock +')" '+estilomensaje+'><div class="'+extra+' InfoLittlePoint InfoList"> </div> ' +v.Message+'</li>');}
    });
    
    items.push('</ul></div>');

    $('.BoxAlert').tooltipster({
      animation: 'fade',
      delay: 200,
      interactive:true,
      content: items.join(''),
      contentAsHTML: true,
      theme: 'Light',
      trigger: 'click'
    });
  });

} //  End of ShowAlert


function LoadAlert(){
  clearInterval(actualizarProceso);
  clearInterval(actualizarEstacion);
  clearInterval(actualizarParametro);
  $("section").html("Cargando vista ALERTAS ...");
  $(nodo).html("");
  LoadNav(1);
}


/*
*   CONTROLES PARA VISTA DE INFORMES
* las siguientes funciones se encargan de utilizar la informacion recibida por JSON para 
* mostrar informes estadisticos de las vistas 
*/

function Export(){

  $("section").css("background-color","#ffffff");
  clearInterval(actualizarProceso);
  clearInterval(actualizarEstacion);
  clearInterval(actualizarParametro);

  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();

  if(dd<10) {
      dd='0'+dd
  } 

  if(mm<10) {
      mm='0'+mm
  } 

  today = yyyy+'-'+mm+'-'+dd;

  var cadena = '';
  cadena += '<div id="CuadroFechas" class="col-md-12" >';
  cadena += ' <div class="col-md-6 col-sm-6 col-xs-12" >';
  cadena += '   <span><br>Fecha de inicio de reporte de monitoreo</span>';
  cadena += '   <div class="input-group">';
  cadena += '     <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>';
  cadena += '     <input type="date" id="Date1"  class="form-control" aria-describedby="basic-addon1">';
  cadena += '   </div>';
  cadena += '   <span><br>Fecha final del reporte de monitoreo</span>';
  cadena += '   <div class="input-group">';
  cadena += '     <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>';
  cadena += '     <input type="date" id="Date2"  class="form-control" aria-describedby="basic-addon1">';
  cadena += '   </div>';
  cadena += ' </div>';
  cadena += ' <div class="col-md-6 col-sm-6 col-xs-12 text-center" ><br>';
  cadena += '   <button type="button" onclick="chargeValuesDate()" class="btn btn-primary btn-generar"><i class="fa fa-bar-chart" aria-hidden="true"></i> Generar</button>';
  cadena += '   <button type="button" class="btn btn-primary btn-imprimir" onclick="imprimir()"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>';
  cadena += ' </div>';
  cadena += '</div>';
  cadena += '<div id="cargando" class="col-md-12" ><p><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></p><p>Generando reporte...</p></div>';
  cadena += '<div id="Reporte" class="col-md-12" > </div>';

  $("section").html(cadena);
  $("#Date1").val(today);
  $("#Date2").val(today);
}


var dataProbe;
function chargeValuesDate(){
  
  $("#Reporte").html("<h3 class='title-reporte'></h3>");
  $("footer").hide();
  $parametros = {
    'date1' : document.getElementById("Date1").value+" 00:00:00",
    'date2' : document.getElementById("Date2").value+" 23:59:59",

/*    'date1' : "2016-09-08" +" 00:00:00",
    'date2' : "2016-09-14" +" 23:59:59",*/
  };

  var date1=$("#Date1").val();
  var date2=$("#Date2").val();
  $url = "history/form";

  //Ajax para pedir los datos que se mostrarán en las gráficas
  $.ajax({
    type: "GET",
    url: $url,
    data: $parametros,
    dataType : "json",
    success: function(data){
      //Imprime el párrafo donde se deja indicado las fechas del reporte
      $(".title-reporte").html("Las fechas del reporte son del: "+date1+" hasta "+date2);
      var grafica='';
      grafica +='<div class="graficas">'
      $.each(data.ProcessBlock[0].StationBlock, function(key, value) {
          grafica +=' <div class="panel panel-success mg-3 mgt-70px"><div class="panel-heading"><h3 class="panel-title sensor-name">'+(key+1)+'. '+value.Name+'</h3></div>'
          $.each(value.Sensor, function(k, val) {
            //solo imprime las gráficas que contengan información
            if(val.MaxValue==0 && val.MeanValue==0 && val.MinValue==0){}
            else{ 
            if(val.Tendencia==0) flecha="glyphicon-minus";
            else if (val.Tendencia>0) flecha="glyphicon-upload";
            else if (val.Tendencia<0) flecha="glyphicon-download";
              
          grafica +='   <div class="panel-body"><h3 class="title-sensor">'+(key+1)+'.'+(k+1)+' '+val.Name+'</h3>'
          grafica +=    '<div class="col-sm-9"><div id="'+value.id+''+val.id+'" style="width:100%;height:300px;margin:0 auto;border:1px solid #ccc;"></div></div>'
          grafica +=    '<div class="col-sm-3"><div class="cuadro-info text-center">'
          grafica +=     '<p><div class="half right">Máximo:</div><div class="bold">'+val.MaxValue+'</div></p><p><div class="half right">Medio:</div><div class="bold">'+val.MeanValue+'</div></p><p><div class="half right">Mínimo:</div><div class="bold">'+val.MinValue+'</div></p></div>'
          grafica +=    ' <div class="tendencia"><div class="glyphicon float-left '+flecha+'"></div><div class="porcentaje"><p>Tendencia</p><p>'+val.Tendencia+' %</p></div></div></div>'
          grafica +=   '</div>'
              }
          
            });
          grafica +=' </div>';
          
          });
          grafica +='</div>'
          $("#Reporte").append(grafica);

          $.each(data.ProcessBlock[0].StationBlock, function(key, value) {
          
            $.each(value.Sensor, function(k, val) {
                  if(val.MaxValue==0 && val.MeanValue==0 && val.MinValue==0){}
                  else{

              var Data = [];
              // Generando la data para la grafica
              for (var a=0;a<val.Data.Value.length ;a++){

                //Si val.Data.timestamp[a] se recibe como un texto del tipo '2016-03-11 11:00:00' usar lo siguiente
                var d = new Date(val.Data.timestamp[a]).getTime();
                //console.log(d);
                // para solucionar el problema de cambio de horario
                d = d - 18000000;
                Data.push([d, val.Data.Value[a]]);
                
                //Si val.Data.timestamp[a] se recibe como el valor Unix  se puede utilizar asi
          /*      Data.push([val.Data.timestamp[a], val.Data.Value[a]]);*/
                  }
                  // Se establecen las caracteristicas de de la gráfica
                  var OptionChart = {
                    // El selecionador de períodos
                    rangeSelector: {
                      selected: 4,
                      buttons: [{
                        type: 'hour',
                        count: 24,
                        text: '24h'},
                      {
                        type: 'day',
                        count: 7,
                        text: '1w'},
                      {
                        type: 'month',
                        count: 1,
                        text: '1m'},
                      {
                        type: 'year',
                        count: 1,
                        text: '1y'},
                      {
                        type: 'all',
                        text: 'All'}],
                      inputEnabled: false,
                    },
                    // se configura el scrollbar inferior
                    scrollbar:{
                      enabled: false,
                    },
                    // se configura del navegador
                    navigator: {
                        enabled: false
                    },

                    title: {
                        text: val.Unit+" vs Tiempo"
                    },

                    // Se definen las líneas adicionales para indicar límites
                    yAxis: {
                        title: {
                            text: "Nivel de "+ val.Name
                        },
                        plotLines: [{
                            value: val.MinValue,
                            color: 'green',
                            dashStyle: 'shortdash',
                            width: 2,
                            label: {
                                text: 'Punto Mínimo'
                            }
                        }, {
                            value: val.MeanValue,
                            color: 'blue',
                            dashStyle: 'shortdash',
                            width: 2,
                            label: {
                                text: 'Media Total'
                            }
                        }, {
                            value: val.MaxValue,
                            color: 'red',
                            dashStyle: 'shortdash',
                            width: 2,
                            label: {
                                text: 'Punto Máximo'
                            }
                        }]
                    },


                    // configuración de la posicion de la gráfica
                    credits: {
                        position: {
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    },
                    // Se ingresan los datos obtenidos
                    series: [{
                        name: val.Name,
                        data: Data,
                        tooltip: {
                            valueDecimals: 2
                        }
                    }]
                  }; // Fin option charts

                  //se imprime la gráfica 
                  Highcharts.stockChart(''+value.id+''+val.id,OptionChart);
                  }
               }); 
            }); 
            
            //Ajax para pedir los datos que se mostrarán en las tablas de eventos (peligro y riesgo)
            $.ajax({
            type: "GET",
            url: "history/events",
            data: $parametros,
            dataType : "json",
            success: function(data){

              if(data.LongDanger!=0){

              var tdanger='';
                  tdanger += '<div class="panel panel-danger mg-3"><div class="panel-heading" onclick="dropdownDanger()"><h3 class="panel-title">Reporte de alertas en estado crítico <span>('+data.LongDanger+')</span><i class="glyphicon glyphicon-chevron-down float-right"></i></h3></div>'
                  tdanger +=   '<div class="panel-body" id="body-danger" style="display:none"><div class="table-responsive"><table class="table">'
                  tdanger +=    '<thead class="danger"><tr><th>N° de alerta</th><th>Punto de monitoreo</th><th>Parámetro</th><th>Fecha</th><th>Incidente</th></tr></thead>';
                  $.each(data.Danger, function(k, val) {
                  tdanger +=    '<tbody><tr><td>'+(k+1)+'</td><td>'+val.StationBlock+'</td><td>'+val.Sensor+'</td><td>'+val.Date+'</td><td>'+val.Message+'</td></tr>'
                  }); 
                  tdanger+=     '</tbody></table></div></div></div>'
              $("#Reporte").append(tdanger); 
                  }

              if(data.LongRisk!=0){

              var trisk='';
                  trisk += '<div class="panel panel-warning mg-3"><div class="panel-heading" onclick="dropdownRisk()"><h3 class="panel-title">Reporte de alertas <span>('+data.LongRisk+')</span><i class="glyphicon glyphicon-chevron-down float-right"></i></h3></div>'
                  trisk +=   '<div class="panel-body" id="body-risk" style="display:none"><div class="table-responsive"><table class="table">'
                  trisk +=    '<thead class="warning"><tr><th>N° de alerta</th><th>Punto de monitoreo</th><th>Parámetro</th><th>Fecha</th><th>Incidente</th></tr></thead>';
                  $.each(data.Risk, function(k, val) {
                  trisk +=    '<tbody><tr><td>'+(k+1)+'</td><td>'+val.StationBlock+'</td><td>'+val.Sensor+'</td><td>'+val.Date+'</td><td>'+val.Message+'</td></tr>'
                  }); 
                  trisk+=     '</tbody></table></div></div></div>'
              $("#Reporte").append(trisk); 
                  }
                
                }
             }); 
            
          } //fin success de ajax de carga de datos para las gráficas
         
      }); //fin ajax de carga de datos para las gráficas
  
  //se imprime el footer
  $("body").append("<footer>Copyright © Waposat 2016</footer>");
}

/**dropdown de la tabla de eventos**/
function dropdownDanger(){
  var display=$("#body-danger").css("display");
  if (display=="none") { 
    $("#body-danger").slideDown(500);
    $(".panel-danger").find("i").removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
    }
  else {
    $("#body-danger").slideUp(500);
    $(".panel-danger").find("i").removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
  }
}

function dropdownRisk(){
  var display=$("#body-risk").css("display");
  if (display=="none") { 
    $("#body-risk").show();
    $(".panel-warning").find("i").removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
    }
  else {
    $("#body-risk").slideUp(500);
    $(".panel-warning").find("i").removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
  }
  
}

/**Efecto loading cuando se efectúa una petición ajax**/
$(document).ajaxStart(function(){
    $("#cargando").css("display","block");
});

$(document).ajaxComplete(function(){
    $("#cargando").slideUp(1000);
});

/**Función del botón Imprimir**/

function imprimir(){
  window.print();
}


/*
* CloseSession
* Cierra la sesion borrando la variable de usuario y redirigiendo al Login
*/
function CloseSession(){
    
  if (confirm("Cerrar Sesi\u00F3n")) {

    window.location.assign("http://monitoreo.waposat.com/logout");
  } 
} //  End of CloseSession



/*
* drawChart
* Genera la grafica Gauge para la medicion de un Sensor
*/
google.charts.load('current', {'packages':['gauge','corechart', 'line']});    

function drawChart(id,l,v,dangerini,dangerfin,riskini,riskfin) {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          [l, v]
        ]);

        var options = {
          min:0, max:dangerfin,
          redFrom:dangerini, redTo: dangerfin,
          yellowFrom:riskini, yellowTo: riskfin,
          minorTicks: 5
        };

        var chartG = new google.visualization.Gauge(document.getElementById(id));
        chartG.draw(data, options);
}

 
/*
* drawCurveTypes
* Se encarga de generar la grafica Lineal de los datos del Sensor
*/
var chartLine;
var dataLine;
var optionsLine;
function drawCurveTypes(id,w,h,datos,titulo){

  dataLine = new google.visualization.DataTable();
  dataLine.addColumn('timeofday', 'X');
  dataLine.addColumn('number', titulo);
  dataLine.addColumn('number', 'Risk');
  dataLine.addColumn('number', 'Danger');

  dataLine.addRows(JSON.parse(datos));

  optionsLine = {
    // ** por algun motivo el title y subtitle no funcionan
    chart: {
      title: titulo,
      subtitle: 'mg/L vs Tiempo',
      curveType: 'function'
    },
    width: w,
    height: h,
    chartArea: {'right':20,'width': '80%', 'height': '75%'},
    legend: {position: 'none'},
    hAxis: {gridlines: {count: 5}},
    //vAxis: {viewWindow: { min:0}}, // Si se desea que la grafica tenga como limite inferior a cero
    colors: ['#256088', '#efa331', '#a73836']};
  chartLine = new google.visualization.LineChart(document.getElementById(id));
  chartLine.draw(dataLine, optionsLine);
} //  End drawCurveTypes


/*
* UpdateCurveTypes
* Actualiza la informacion de la grafica de Lineal de los datos del Sensor
*/
function UpdateCurveTypes(datos){
  
  $.each(JSON.parse(datos), function(key, val) {
    dataLine.removeRow(dataLine.getNumberOfRows()-1);
  });

  dataLine.insertRows(0,JSON.parse(datos));

  chartLine.draw(dataLine, optionsLine);

  // Secuencia para actualizar la media, max y min
  var val = dataLine.getColumnRange(1);

  var acum =0; // creando el acumulador
  var size = dataLine.getNumberOfRows();

  for(var i=0; i<size ; i++){
    acum += dataLine.getValue(i,1);
  }
  var mean = acum/size;
  // Actualizando los valores
  $("#MinValueSensors").html(val.min.toFixed(2));
  $("#MaxValueSensors").html(val.max.toFixed(2));
  $("#MeanValueSensors").html(mean.toFixed(2));  
}


function calBoxCol(){
	var contentWidth = $('.boxcols').width();
	var boxCols = 0;
  var boxwidth=null;
	
  if (contentWidth > 1900){
		boxCols = 7;
		boxwidth = Math.floor(contentWidth / boxCols) * 0.99;
	} else if (contentWidth < 1900 && contentWidth > 1400 ) {
		boxCols = 6;
		boxwidth = Math.floor(contentWidth / boxCols) * 0.99;
	} else if (contentWidth < 1400 && contentWidth > 1000 ){
		boxCols = 5;
		boxwidth = '20%';
	} else if (contentWidth < 1000 && contentWidth > 800 ){
		boxCols = 4;
		boxwidth = '25%';
	} else if (contentWidth < 800 && contentWidth > 640 ){
		boxCols = 3;
		var boxwidth = '33.3%';
	} else if (contentWidth < 640 && contentWidth > 480 ){
		boxCols = 2;
		boxwidth = '50%';
	} else if (contentWidth < 480){
		boxCols = 1;
		boxwidth = '100%';
	}

	$(".boxcols .box").css("width",boxwidth);
}


var boxCaugeCols=0;
function ResizeCol(){
	var contentWidth = $('.Group').width();
	boxCaugeCols = 0;
  var boxwidth;
  if($(document).width()<=800){
    $(".DetailBlock").css("width","100%");
    $(".Block").css("width","100%");
  }
  else{
    $(".DetailBlock").css("width","50%");
    $(".Block").css("width","50%");
  }
      
  if (contentWidth > 1300){
  //if (contentWidth > 1400){
		boxCaugeCols = 7;
		boxwidth = Math.floor(contentWidth / boxCols) * 0.99;
  } else if (contentWidth <= 1300 && contentWidth > 1000 ) {
	//} else if (contentWidth < 1400 && contentWidth > 1200 ) {
		boxCaugeCols = 6;
		boxwidth = '16.6%';
  } else if (contentWidth <= 1000 && contentWidth > 750 ){
	//} else if (contentWidth < 1200 && contentWidth > 940 ){
		boxCaugeCols = 5;
		boxwidth = '20%';
  } else if (contentWidth <= 750 && contentWidth > 600 ){
	//} else if (contentWidth < 940 && contentWidth > 660 ){
		boxCaugeCols = 4;
		boxwidth = '25%';
	} else if (contentWidth <= 600 && contentWidth > 480 ){
		boxCaugeCols = 3;
		var boxwidth = '33.3%';
  } else if (contentWidth <= 480 && contentWidth > 340 ){
	//} else if (contentWidth < 480 && contentWidth > 340 ){
		boxCaugeCols = 2;
		boxwidth = '50%';
	} else if (contentWidth <= 340){
		boxCaugeCols = 1;
		boxwidth = '100%';
	}

	$(".Group .ItemBox").css("width",boxwidth);
}


$(window).resize(function() {
	calBoxCol();
  ResizeCol();
});


function launchFullscreen() {
    element=document.documentElement;
  if(element.requestFullscreen) {
    element.requestFullscreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.webkitRequestFullscreen) {
    element.webkitRequestFullscreen();
  } else if(element.msRequestFullscreen) {
    element.msRequestFullscreen();
  }
}

function exitFullscreen() {
  if(document.exitFullscreen) {
    document.exitFullscreen();
  } else if(document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if(document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  }
}

function dumpFullscreen() {
  console.log("document.fullscreenElement is: ", document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement);
  console.log("document.fullscreenEnabled is: ", document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled || document.msFullscreenEnabled);
}

// Events
document.addEventListener("fullscreenchange", function(e) {
  console.log("fullscreenchange event! ", e);
});
document.addEventListener("mozfullscreenchange", function(e) {
  console.log("mozfullscreenchange event! ", e);
});
document.addEventListener("webkitfullscreenchange", function(e) {
  console.log("webkitfullscreenchange event! ", e);
});
document.addEventListener("msfullscreenchange", function(e) {
  console.log("msfullscreenchange event! ", e);
});


