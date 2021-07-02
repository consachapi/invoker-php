<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">

<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Web ReFirma</title> 	
	<link rel="stylesheet"	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript"src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	
	<script type="text/javascript" src="https://dsp.reniec.gob.pe/refirma_invoker/resources/js/client.js"></script>
<!-- 	<script type="text/javascript" src="http://localhost:8080/refirma_invoker/resources/js/client.js"></script> -->
	<script type="text/javascript">	
		//<![CDATA[
			var documentName_ = null;
			//
			window.addEventListener('getArguments', function (e) {								
				type = e.detail;					
				if(type === 'W'){
					ObtieneArgumentosParaFirmaDesdeLaWeb(); // Llama a getArguments al terminar.
			    }else if(type === 'L'){
			    	ObtieneArgumentosParaFirmaDesdeArchivoLocal(); // Llama a getArguments al terminar.
			    } 				    
			});
			function getArguments(){	
				arg = document.getElementById("argumentos").value;				
				dispatchEventClient('sendArguments', arg);																
			}
			
			window.addEventListener('invokerOk', function (e) { 
				type = e.detail;		   
				if(type === 'W'){
					MiFuncionOkWeb();	
			    }else if(type === 'L'){
			    	MiFuncionOkLocal();	
			    }	
			});
			
			window.addEventListener('invokerCancel', function (e) {    
				MiFuncionCancel();	
			});

			//::LÓGICA DEL PROGRAMADOR::			
			function ObtieneArgumentosParaFirmaDesdeLaWeb(){
				document.getElementById("signedDocument").href="#";
				$.get("controller/getArguments.php", {}, function(data, status) {			
					documentName_ = data;	
					//Obtiene argumentos
					$.post("controller/postArguments.php", {
						type : "W",
						documentName : documentName_
					}, function(data, status) {					
						//alert("Data: " + data + "\nStatus: " + status);
						document.getElementById("argumentos").value = data;
						getArguments();
					});
													
				});				
			}

			function ObtieneArgumentosParaFirmaDesdeArchivoLocal(){
				document.getElementById("signedDocument").href="#";
				$.get("controller/getArguments.php", {}, function(data, status) {			
					documentName_ = data;	
					//Obtiene argumentos
					$.post("controller/postArguments.php", {
						type : "L",
						documentName : documentName_
					}, function(data, status) {
						//alert("Data: " + data + "\nStatus: " + status);
						document.getElementById("argumentos").value = data;
						getArguments();
					});
													
				});
				
			}
			
			function MiFuncionOkWeb(){
				alert("Documento firmado desde una URL correctamente.");
				document.getElementById("signedDocument").href="controller/getFile.php?documentName=" + documentName_;
			}

			function MiFuncionOkLocal(){
				alert("Documento firmado desde la PC correctamente.");
				document.getElementById("signedDocument").href="controller/getFile.php?documentName=" + documentName_;
			}
			
			function MiFuncionCancel(){
				alert("El proceso de firma digital fue cancelado.");
				document.getElementById("signedDocument").href="#";
			}								
		//]]>
	</script>	
	<style type="text/css">
	  footer{
		    background-color: #222222;
		    position: fixed;
		    bottom: 0;
		    left: 0;
		    right: 0;
		    height: 40px;
		    text-align: center;
		    color: #CCC;
		}
		
		footer p {
		    padding: 14px;
		    margin: 0px;
		    line-height: 100%;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">				
				<br />
				<p>
					<a class="btn btn-danger" href="#" role="button" onclick="initInvoker('W');">Firmar</a>
					<a class="btn btn-success" href="#" role="button" onclick="initInvoker('L');">PC</a>
				</p>
				<br />
				<p>
					<a id="signedDocument" class="btn btn-default" href="#" role="button">Ver</a>					
				</p>
				
			</div>					
		</div>

		<hr>

		<footer>
			<p>Registro Nacional de Identificación y Estado Civil - RENIEC / <a href="http://www.gobiernodigital.gob.pe/" style="color: #CCC;" > Secretaría de Gobierno Digital SeGDi-PCM </a></p>
		</footer>
		
		<input type="hidden" id="argumentos" value="" />
		<div id="addComponent"></div>
	</div>
	<!-- /container -->

</body>
</html>